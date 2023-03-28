<?php
namespace App\Libraries\Traits;

use Closure;
use DB;
use Exception;
use Throwable;
use App\Libraries\Helpers\Response;

trait TryCatch {

    public function tryCatch(Closure $callback, $exception = false) {

        $response = new Response;

        $localTransaction = DB::transactionLevel() ? false : true;

        if($localTransaction) {

            DB::beginTransaction();

        }

        try {

            $result = $callback($response);

            if($localTransaction) {

                DB::commit();

            }

            $response->setData($result);

        } catch (Throwable $e) {

            if($localTransaction) {

                DB::rollback();

            }

            if($exception) {

                throw new Exception($e->getMessage());

            }

            $response->setError($e->getMessage());

        }

        return $response;

    }
}
