<?php
class ads
{
    protected $title;
    protected $price;
    protected $author_id;
    
    public function __construct(array $data) 
    {
        $this->price       =   $data['price'];
        $this->author_id   =   $data['author_id'];
        $this->title       =   $data['title'];

    }
    
        public function getTitle()
    {
        return $this->title;
    }
        public function getPrice()
    {
        return $this->price;
    }
        public function getAuthor_id()
    {
        return $this->author_id;
    }
    

}

