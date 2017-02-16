<div class="row">
    <div class="alert alert-success" role="alert" id="info_success" style="display: none"></div>
    <div class="alert alert-danger" role="alert" id="info_error" style="display: none"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3>Passwort ändern</h§>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <p class="text-center">3 von 4 Regeln müssen erfüllt sein!</p>
                <form method="post" id="passwordForm">
                    <input type="password" class="form-control" name="password1" id="password1" placeholder="Neues Passwort" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-6">
                            <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Mindestens 8 Zeichen<br>
                            <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Mindestens ein Großbuchstaben
                        </div>
                        <div class="col-sm-6">
                            <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Mindestens ein Kleinbuchstaben<br>
                            <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Mindestens eine Ziffer
                        </div>
                    </div>
                    <input type="password" class=" form-control" name="password2" id="password2" placeholder="Wiederhole das neue Paswort" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Passwörter stimmen überein
                        </div>
                    </div>
                    <input type="button" class="col-xs-12 btn btn-primary btn-load" id="change-btn" value="Passwort ändern">
                </form>
            </div><!--/col-sm-6-->
        </div><!--/row-->
    </div>
</div>

<script type="text/javascript" src="js/settings.js"></script>