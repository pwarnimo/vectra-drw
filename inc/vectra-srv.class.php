<?php

include "config.inc.php";

class VectraServer {
    private $dbh;
    
    public function __contruct() {
        $dsn = dbtype . ":dbname=" . database . ";host=" . hostname;
        
        try {
            $this->dbh = new PDO($dsn, username, password);
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " . $e->getMessage();
            die();
        }
    }
    
    /*
     * dID = Drawing ID
     *
     */
    
    public function addDrawing($dID, $x, $y, $width, $height, $color, $type, $filled, $type) {
        $update = date("Y\-m\-d H\:i\:s");
        
        $qry = "INSERT INTO tblDrawing (dtX, dtY, dtWidth, dtHeight, dtColor, dtType, dtFilled, dtLastUpdate) VALUES (:x, :y, :width, :height, :color, :type, :filled, :update) WHERE fiDrawing = :dID";
        
        $stmt = $this->dbh->prepare($qry);
        
        $stmt->bindValue(":dID", $dID, PDO::PARAM_INT);
        $stmt->bindValue(":x", $x, PDO::PARAM_INT);
        $stmt->bindValue(":y", $y, PDO::PARAM_INT);
        $stmt->bindValue(":width", $width, PDO::PARAM_INT);
        $stmt->bindValue(":height", $height, PDO::PARAM_INT);
        $stmt->bindValue(":color", $color, PDO::PARAM_STR);
        $stmt->bindValue(":type", $type, PDO::PARAM_INT);
        $stmt->bindValue(":filled", $filled, PDO::PARAM_BOOL);
        $stmt->bindValue(":update", $update, PDO::PARAM_STR);
        
        $stmt->execute();

    }

    public function getAvailableDrawings() {
        $qry = "SELECT idDrawing FROM tblDrawing";

        $stmt = $this->dbh->prepare($qry);

        $stmt->execute(PDO::FETCH_ASSOC);


    }
}