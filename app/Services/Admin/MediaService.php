<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreMediaRequest;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\ConsoleOutput;

class MediaService extends BaseService
{
    private $mediaPath = 'public/media';
    private $importPath = 'public/import';

    /**
     * All
     *
     * @return Media[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Media::paginate(request()->input('per_page', $this->paginate_per_page));
    }

    /**
     * Create
     *
     * @param StoreMediaRequest $request
     * @return mixed
     */
    public function create(StoreMediaRequest $request)
    {
        $data = $request->validated();

        if($data['attachment']) {
            $hash = $data['attachment']->hashName();
            $path = $data['attachment']->storeAs($this->mediaPath . '/' . $hash[0], $hash);

            if ($path) {
                return Media::create([
                    'path' => $path,
                    'name' => $data['attachment']->getClientOriginalName(),
                    'extension' => $data['attachment']->getClientOriginalExtension(),
                    'size' => $data['attachment']->getSize()
                ]);
            }

            $media = Media::create($data);
            return $media::find($media->id);
        }

        return false;
    }

    /**
     * Get
     *
     * @param Media $media
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function get(Media $media)
    {
        return Media::find($media->id);
    }

    /**
     * Delete
     *
     * @param Media $media
     * @return bool
     */
    public function delete(Media $media)
    {
        $url = $media->path;
        // Remove file
        Storage::exists($url) && Storage::delete($url);

        $media->delete();
        return true;
    }

    /**
     * Imported files from import catalog and write itto DB table
     * Using for seeding DB
     */
    public function import()
    {
        $paths = Storage::allFiles($this->importPath);

        foreach ($paths as $path) {
            // File prepare data
            $storagePath = storage_path('app/' . $path);

            $fileHash = hash('SHA1', $storagePath);
            $fileName = \Illuminate\Support\Facades\File::name($storagePath);
            $fileExtension = \Illuminate\Support\Facades\File::extension($storagePath);
            $fileSize = \Illuminate\Support\Facades\File::size($storagePath);
            $fileNewPath = $this->mediaPath . '/' . $fileHash[0] . '/' . $fileHash . '.' . $fileExtension;

            Storage::copy($path, $fileNewPath);

            // Create File
            Media::create([
                'path' => $fileNewPath,
                'name' => $fileName . '.' . $fileExtension,
                'extension' => $fileExtension,
                'size' => $fileSize
            ]);

            (new ConsoleOutput())->writeln('<info>import:</info> ' . $path . '...');
        }
    }

    /**
     * Deleted all media files
     * Using when need clean catalog (Before seeding)
     */
    public function deleteMediaFiles()
    {
        Storage::deleteDirectory($this->mediaPath);
    }
}
