<?php
    /**
     *
     */
    class Album
    {
        private $con;
        private $id;
        private $title;
        private $artistId;
        private $genre;
        private $artworkPath;


        // crete artist class constructor
        function __construct($con,$id)
        {
            $this->con = $con;
            $this->id = $id;

            $albumQuery = mysqli_query($con,"SELECT * FROM Albums WHERE id='$this->id'");
            $album = mysqli_fetch_array($albumQuery);  // this will asssign a array  to album

            $this->title = $album['title'];
            $this->artistId = $album['artist'];
            $this->genre = $album['genre'];
            $this->artworkPath = $album['artworkPath'];
        }

        public function getAlbumTitle(){
            return $this->title;
        }

        public function getAlbumArtistName(){
            /* this will give only object refrence of Artist class not answer,if you want to print the artist name you want print by store this result in one variable,now
            this varible is become a object and by this call getArtistName() method. */
            return new Artist($this->con,$this->artistId);
        }

        public function getAlbumGenreName(){
            return $this->genre;
        }

        public function getAlbumArtworkPath(){
            return $this->artworkPath;
        }

        public function getNumberOfSongsFromAlbums(){
            $noOfSongsQuery = mysqli_query($this->con, "SELECT id FROM Songs WHERE album='$this->id' ");
            return mysqli_num_rows($noOfSongsQuery);
        }

        public function getSongIdsFromAlbums(){
            $songsIdQuery = mysqli_query($this->con, "SELECT id FROM Songs WHERE album='$this->id' ORDER BY albumOrder ASC");

            $songsIdArray = array();
            while($row = mysqli_fetch_array($songsIdQuery)){
                    array_push($songsIdArray,$row['id']);
            }

            return $songsIdArray;
        }

    }



?>
