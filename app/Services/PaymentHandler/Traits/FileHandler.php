<?php

namespace App\Services\PaymentHandler\Traits;

trait FileHandler {
    /**
     * Read CSV file.
     *
     * @return array of data
     */
    protected function read_file(string $csvFile): array{

        $result = [];
        if (($open = fopen(storage_path() . "/" . trim($csvFile,"/"), "r")) !== FALSE) {
            while (($data = fgetcsv($open, 100000, ",")) !== FALSE) {
                $result[] = $this->compile_row($data);
            }
            fclose($open);
        }

        return $result;
    }

    /**
     * Preparing the data row.
     *
     * @return array of data row
     */
    protected function compile_row(array $array): array {
        $result = [];
        if (!empty($array[5])){
            if(empty($array[2]) || !in_array($array[2],["private","business"])) {
                throw new \Exception($array[2] . ' is not in user type list.');
            }
            if(empty($array[3]) || !in_array($array[3],["deposit","withdraw"])) {
                throw new \Exception($array[3] . ' is not in operation type list.');
            }
            if(empty($array[5]) || !in_array($array[5],array_keys(Config("payment.currencies")))) {
                throw new \Exception($array[5] . ' is not in currency list.');
            }

            $result["date"]         = !empty($array[0]) ? trim($array[0]) : "";
            $result["user_id"]      = !empty($array[1]) ? trim($array[1]) : "";
            $result["user_type"]    = !empty($array[2]) ? trim($array[2]) : "";
            $result["op_type"]      = !empty($array[3]) ? trim($array[3]) : "";
            $result["amount"]       = !empty($array[4]) ? trim($array[4]) : "";
            $result["currency"]     = !empty($array[5]) ? trim($array[5]) : "";
        }
        return $result;
    }
}
