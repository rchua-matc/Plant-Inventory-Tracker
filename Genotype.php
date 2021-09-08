<?php
    // Represents a distinct genotypic line in the plant collection
    class Genotype
    {
        private $name;
        private $category;
        private $calcium;
        private $transgenic;
        private $notes;

        // Getters
        public function getName()
        {
            return $this->name;
        }

        public function getCategory()
        {
            return $this->category;
        }

        public function getCalcium()
        {
            return $this->calcium;
        }

        public function getTransgenic()
        {
            return $this->transgenic;
        }

        public function getNotes()
        {
            return $this->notes;
        }

        // Setters
        public function setName($name)
        {
            $this->name = $name;
        }

        public function setCategory($category)
        {
            $this->category = $category;
        }

        public function setCalcium($calcium)
        {
            $this->calcium = $calcium;
        }

        public function setTransgenic($transgenic)
        {
            $this->transgenic = $transgenic;
        }

        public function setNotes($notes)
        {
            $this->notes = $notes;
        }

        // Adds the genotype to the DB through the passed connection
        public function addGenotype($connection)
        {
            $query = "INSERT INTO genotype VALUES (0, '$this->name', '$this->category', $this->calcium, '$this->transgenic', '$this->notes')";
            $result = mysqli_query($connection, $query)
                    or die('Error querying database');
        }
    }
?>