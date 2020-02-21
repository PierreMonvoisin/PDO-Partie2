<?php

require_once 'DataBase.php';

/**
 * Description of Appointments
 *
 * @author françois
 */
class Appointments extends DataBase {
    
    /**
     *
     * @var type datetime
     */
    public $dateHour;
    
    /**
     *
     * @var type integer
     */    
    public $idPatient;
    
    
    /**
     * constructeur de la classe Appointments
     */
    public function __construct($date_Hour = '', $id_Patient = '') {
        parent::__construct();
        $this->dateHour = $date_Hour;
        $this->idPatient = $id_Patient;
    }
    
    public function create() {
        $query = 'INSERT INTO `appointments` (`dateHour`, `idPatients`) VALUE (:dateHour, :idPatient)';
        $sth = $this->db->prepare($query);
        $sth->bindValue('idPatient', $this->idPatient, PDO::PARAM_INT);
        $sth->bindValue('dateHour', $this->dateHour, PDO::PARAM_STR);
        if($sth->execute()){
            return $this;
        }
        return false;
    }
    
    /**
     * cette méthode permet de récupérer la liste de tous les rendez-vous de l'hospital.
     * @return type array
     */ 
    public function getAll() {
        //Le code sélectionnant tous les patients
        $sql ='SELECT `patients`.`id` AS ownerId, `lastname` AS ownerLastname, `firstname` AS ownerFirstname, DATE_FORMAT(`dateHour`, \'%d.%m.%Y %H:%i\') `dateHour` FROM `patients`, `appointments` WHERE `patients`.`id` = `appointments`.`idPatients`';
        $patientsRDV = [];
        $sth = $this->db->query($sql);
        if ($sth instanceof PDOStatement) {
            $patientsRDV = $sth->fetchAll(PDO::FETCH_OBJ);
        }
        return $patientsRDV;
    }
    
      /**
     * cette methode permet de recupérer tous les rendez vous d'un patient dans la table appointment s'ils existent.
     * @return boolean|$this
     */
    public function getPatientAppointments($idPatient) {
        //Le code permettant de récupèrer les rendez vous d'un patient
        $sql = 'SELECT  DATE_FORMAT(`dateHour`, "%d.%m.%Y %H:%i") AS `dateHour` FROM `appointments` WHERE `appointments`.`idPatients` = :id';
        $sth = $this->db->prepare($sql);
        $sth->bindValue(':id', $idPatient, PDO::PARAM_INT);
        //Initialisation du tableau
        $appointmentsList = [];
        //Si l'excute se passe bien
        if ($sth->execute()) {//hydrate la fonction, lui attribut des nouvelles valeurs
            if ($sth instanceOf PDOStatement) {
                // Collection des données dans un tableau associatif (FETCH_ASSOC)
                $appointmentsList = $sth->fetchAll(PDO::FETCH_OBJ);
            }
          
        }
        return $appointmentsList;
    }
    
   public function getOneById() {
        //Le code sélectionnant un patient
        $sql = "SELECT `patients`.`id`, `lastname` AS ownerName, `firstname` AS ownerSurname, `dateHour` from `patients`, `appointments` WHERE `patients`.`id` = :id AND `appointments`.`idPatients` = :id";
        $sth = $this->db->prepare($sql);
        $sth->bindValue(':id', $this->id, PDO::PARAM_INT);
        if ($sth->execute()) {
            $rdv = $sth->fetch(PDO::FETCH_OBJ);
            if ($rdv) {
                $this->dateHour = $rdv->dateHour;
                return $this;
            }
        }
        return false;
    }
    
    public function delete() {
        //Le code pour supprimer un patient
        $sql = 'DELETE FROM `appointments` WHERE `idPatients` = :idPatient AND `dateHour` = :datehour';
      $sth = $this->db->prepare($sql);
      $sth->bindValue(':idPatient', $this->idPatient, PDO::PARAM_INT);
      $sth->bindValue(':datehour', $this->dateHour, PDO::PARAM_STR);
      if ($sth->execute() && $sth->rowCount() > 0) {
        return $this;
      }
      return false;
    }

    public function update($oldDateHour) {
        //Le code pour modifier un rendez-vous
        $sql = "UPDATE `appointments` SET `dateHour`= :datehour WHERE `idPatients`= :id AND `dateHour` = :oldDateHour ";
        $sth = $this->db->prepare($sql);
        $sth->bindValue(':id', $this->idPatient, PDO::PARAM_INT);
        $sth->bindValue(':datehour', $this->dateHour, PDO::PARAM_STR);
        $sth->bindValue(':oldDateHour', $oldDateHour, PDO::PARAM_STR);
        if ($sth->execute() && $sth->rowCount() > 0) {
            return $this;
        }
        return false;
    }
    
    
}

