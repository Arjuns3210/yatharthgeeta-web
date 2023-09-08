<?php

namespace App\MediaLibrary;


use App\Models\Banner;
use App\Models\Ashram;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Quote;
use App\Models\Video;
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
            case EventImage::IMAGE;
                return str_replace('{PARENT_DIR}', EventImage::IMAGE, $path);
            case Event::COVER;
                return str_replace('{PARENT_DIR}', Event::COVER, $path);
            case Ashram::IMAGE;
                return str_replace('{PARENT_DIR}', Ashram::IMAGE, $path);
			case Quote::IMAGE;
                return str_replace('{PARENT_DIR}', Quote::IMAGE, $path);
            case Video::COVER_IMAGE;
                return str_replace('{PARENT_DIR}', Video::COVER_IMAGE, $path);
            case Guru::IMAGE;
                return str_replace('{PARENT_DIR}', Guru::IMAGE, $path);
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
