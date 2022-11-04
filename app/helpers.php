<?php

function hasPermission($permission){
    $userPermissions = Session::get('permissions');

    // Renvoi TRUE si l'utilisateur connecté possède la permission ; Sinon FALSE.
    return in_array($permission, $userPermissions);
}

?>
