<?php
namespace App\Libraries\Traits;

use App\Libraries\Helpers\Response;
use Closure;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

trait TryCatch {

    public function tryCatch(Closure $callback, $exception = false, $rollback = true, $logging = null) {

        $response = new Response;
        $localTransaction = DB::transactionLevel() ? false : true;
        if ($localTransaction) {DB::beginTransaction();}

        try {

            $response->setData($callback($response));
            if ($localTransaction) {DB::commit();}

        } catch (Throwable $e) {

            if ($localTransaction) {if ($rollback) {DB::rollback();}}

            if ($exception) {throw new Exception($e->getMessage());}

            $response->setError($e->getMessage());

            if (!empty($logging)) {Log::channel($logging)->error($e);}
        }

        return $response;
    }
}
