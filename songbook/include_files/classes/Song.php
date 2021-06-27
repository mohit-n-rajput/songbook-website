<?php

    class Song{

        private $con;
        private $id;
        private $songQueryData;
        private $title;
        private $artistId;
        private $albumId;
        private $genre;
        private $duration;
        private $path;
        private $plays;

        function __construct($con,$id){
            $this->con = $con;
            $this->id = $id;

            $songQuery = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
            // this hold tha data for our song when each time we need
            $this->songQueryData = mysqli_fetch_array($songQuery);

            // from songQueryData we add more value of Songs
            $this->title = $this->songQueryData['title'];
            $this->artistId = $this->songQueryData['artist'];
            $this->albumId = $this->songQueryData['album'];
            $this->genre = $this->songQueryData['genre'];
            $this->duration = $this->songQueryData['duration'];
            $this->path = $this->songQueryData['path'];

        }

        public function getSongTitle() {
            return $this->title;
        }

        public function getId() {
            return $this->id;
        }

        public function getSongArtist() {
            return new Artist($this->con, $this->artistId);
        }

        public function getSongAlbum() {
            return new Album($this->con,$this->albumId);
        }


        public function getSongPath() {
            return $this->path;
        }

        public function getSongDuration() {
            return $this->duration;
        }

        public function getSongQueryData() {
            return $this->songQueryData;
        }

        public function getSongGenre() {
            return $this->genre;
        }


    }


?>
