<?php

namespace App\Providers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
    /**
     * Generates a storage image for fixtures.
     *
     * @param string $fixturesDir The directory where fixtures are stored.
     * @param string $storageDir The directory where the storage image will be saved.
     * @return string The path to the stored image.
     */
    public function fixturesImage(string $fixturesDir, string $storageDir): string {
        $storage = Storage::disk('images');

        if (!$storage->exists($storageDir)) {
            $storage->makeDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/images/$fixturesDir"),
            $storage->path($storageDir),
            false
        );

        return '/storage/images/' . trim($storageDir, '/') . '/' . $file;
    }
}
