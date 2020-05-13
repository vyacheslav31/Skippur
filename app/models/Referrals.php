<?php

class Referrals extends Model
{
    var $referral_code;
    var $customer_id;
    var $referral_uses;

    public function get()
    {
        $SQL = 'SELECT * FROM referrals';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'referrals');
        return $stmt->fetchAll();
    }

    public function create()
    {
        $SQL = 'INSERT INTO refferals(referral_code, customer_id) VALUES(:referral_code, :customer_id)';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['referral_code'=>$this->referral_code, 'customer_id'=>$this->customer_id]);
        return $stmt->rowCount();
    }

    public function getReferralByCode($code)
    {
        $SQL = 'SELECT * FROM referrals WHERE referral_code = :referral_code';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['referral_code'=>$code]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'referrals');
        return $stmt->fetch();
    }

    public function updateUses()
    {
        $SQL = 'UPDATE referrals SET referral_uses = :referral_uses WHERE referral_code = :referral_code';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['referral_uses'=>$this->referral_uses, 'referral_code'=>$this->referral_code]);
        return $stmt->rowCount();
    }

    public function delete()
    {
        $SQL = 'DELETE FROM referrals WHERE referral_code = :referral_code';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['referral_code'=>$this->referral_code]);
        return $stmt->rowCount();
    }
}

?>