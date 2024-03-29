<?php

class CalendarSqlHelper
{
    /**
     * @return PDO
     */
    function getConn() {
        $conn = new PDO(MYSQL_DSN_XYZ, MYSQL_USER,MYSQL_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    /**
     * use from calendar_quartal.php | $mysql->insertCalendar(time(), $uid, $str);
     * @param $date | time()
     * @param $user_hash | '1130896627'
     * @param $quartal_iii | 9;1;22;3
     * @param $checklist | 0-1-0-1-0-1
     * @return void
     */
    public function insertCalendar($date, $user_hash, $quartal_name, $quartal_value, $checklist_name, $checklist_value){
        try {
            $conn = $this->getConn();
            $statement = $conn->prepare("INSERT INTO calendar (date, user_hash, $quartal_name, $checklist_name VALUES(?,?,?,?)");
            $statement->execute(array($date, $user_hash, $quartal_value, $checklist_value));
            $conn = NULL;
        } catch (PDOException $ex) {
            $conn = NULL;
        }
    }

    /**
     * use calendar_quartal.php | $check = $mysql->checkHashRow($uid);
     * @param $user_hash | '1130896627'
     * @return Exception|mixed|PDOException | array
     */
    public function checkHashRow($user_hash){
        try {
            $conn = $this->getConn();
            $sql = "SELECT * FROM calendar WHERE user_hash='$user_hash';";
            $statement = $conn->prepare($sql);
            $statement->execute();
            $result = $statement->fetch();
            $conn = NULL;
            return $result;
        } catch (PDOException $e) {
            $conn = NULL;
            return NULL;
        }
    }

    /**
     * use calendar_quartal.php |$mysql->updateCalendarValue($check['id'], time(), $str);
     * @param $id | 1
     * @param $date | time()
     * @param $quartal_iii | 9;1;22;3
     * @param $checklist | 0-1-0-1-0-1
     * @return void
     */
    public function updateCalendarValue($id, $date, $quartal_name, $quartal_value, $checklist_name, $checklist_value){
        try {
            $conn = $this->getConn();
            $statement = $conn->prepare("UPDATE calendar SET date=?, $quartal_name=?, $checklist_name=? WHERE id=$id");
            $statement->execute(array($date, $quartal_value, $checklist_value));
            $conn = null;
        }catch (PDOException $e) { $conn = null; }
    }
}