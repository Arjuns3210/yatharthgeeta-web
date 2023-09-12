<?php

namespace App\MediaLibrary;


use App\Models\Audio;
use App\Models\AudioEpisode;
use App\Models\Banner;
use App\Models\Location;
use App\Models\HomeCollection;
use App\Models\HomeCollectionMapping;
use App\Models\Quote;
use App\Models\Video;
use App\Models\Artist;
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
            case Location::IMAGE;
                return str_replace('{PARENT_DIR}', Location::IMAGE, $path);
			case Quote::IMAGE;
                return str_replace('{PARENT_DIR}', Quote::IMAGE, $path);
            case Video::COVER_IMAGE;
                return str_replace('{PARENT_DIR}', Video::COVER_IMAGE, $path);
            case Artist::IMAGE;
                return str_replace('{PARENT_DIR}', Artist::IMAGE, $path);
            case Audio::AUDIO_FILE;
                return str_replace('{PARENT_DIR}', Audio::AUDIO_FILE, $path);
            case Audio::AUDIO_COVER_IMAGE;
                return str_replace('{PARENT_DIR}', Audio::AUDIO_COVER_IMAGE, $path);
            case Audio::AUDIO_SRT_FILE;
                return str_replace('{PARENT_DIR}', Audio::AUDIO_SRT_FILE, $path);
            case AudioEpisode::EPISODE_AUDIO_FILE;
                return str_replace('{PARENT_DIR}', AudioEpisode::EPISODE_AUDIO_FILE, $path);
            case AudioEpisode::EPISODE_AUDIO_SRT_FILE;
                return str_replace('{PARENT_DIR}', AudioEpisode::EPISODE_AUDIO_SRT_FILE, $path);
                case HomeCollection::SINGLE_COLLECTION_IMAGE;
                return str_replace('{PARENT_DIR}', HomeCollection::SINGLE_COLLECTION_IMAGE, $path);
            case HomeCollectionMapping::MULTIPLE_COLLECTION_IMAGE;
                return str_replace('{PARENT_DIR}', HomeCollectionMapping::MULTIPLE_COLLECTION_IMAGE, $path);
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
