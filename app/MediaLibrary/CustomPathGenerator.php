<?php

namespace App\MediaLibrary;


use App\Models\Audio;
use App\Models\Banner;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 */
class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $path = '{PARENT_DIR}'.DIRECTORY_SEPARATOR.$media->id.DIRECTORY_SEPARATOR;

        switch ($media->collection_name) {
            case Banner::COVER;
                return str_replace('{PARENT_DIR}', Banner::COVER, $path);
            case Audio::AUDIO_FILE;
                return str_replace('{PARENT_DIR}', Audio::AUDIO_FILE, $path);
            case Audio::AUDIO_COVER_IMAGE;
                return str_replace('{PARENT_DIR}', Audio::AUDIO_COVER_IMAGE, $path);
            case Audio::AUDIO_SRT_FILE;
                return str_replace('{PARENT_DIR}', Audio::AUDIO_SRT_FILE, $path);
            case 'default';
                return '';
        }
    }

    /**
     * @param  Media  $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'thumbnails/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'rs-images/';
    }
}

