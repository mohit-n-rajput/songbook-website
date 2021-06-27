<?php
    /**
     *
     */
    class Artist
    {
        private $con;
        private $id;

        // crete artist class constructor
        function __construct($con,$id)
        {
            $this->con = $con;
            $this->id = $id;
        }

        public function getArtistId() {
            return $this->id;
        }

        public function getArtistName(){
            //here this->id is artistId which get from album selection.
            $artistQuery = mysqli_query($this->con, "SELECT name FROM Artists WHERE id='$this->id'");
            $artist = mysqli_fetch_array($artistQuery);  // this will asssign a array  to album

            return $artist['name'];
        }



        public function getSongIdsFromArtists() {

            /*we order it for asc to show most populat song.*/
            $query = mysqli_query($this->con, "SELECT id FROM Songs WHERE artist='$this->id' ORDER BY plays ASC");

            $array = array();

            while($row = mysqli_fetch_array($query)) {
                array_push($array, $row['id']);
            }

            return $array;

        }
    }
?>
