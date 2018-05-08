<?php namespace Bishopm\Bible\Repositories;

use Bishopm\Bible\Repositories\EloquentBaseRepository;

class VersesRepository extends EloquentBaseRepository
{
    public function chapter($version, $book, $chapter)
    {
        return $this->model->where('version_id', $version)->where('book_id', $book)->where('chapter', $chapter)->orderBy('verse')->get();
    }
}
