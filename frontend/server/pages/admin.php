<?php
$up = $_GET["up"];
if (!(isset($up) && !empty($up))) {
    $up = "users";
}
?>
<div class="row">
    <div class="col-md-3">
        <p class="lead">Administration</p>
        <div class="list-group">
            <a href="index.php?page=admin&up=users" class="list-group-item<?php
            if ($up === "users") {
                echo " active";
            }
            ?>">Benutzer verwalten</a>
            <a href="index.php?page=admin&up=log" class="list-group-item<?php
            if ($up === "log") {
                echo " active";
            }
            ?>">Logs</a>
            <a href="index.php?page=admin&up=settings" class="list-group-item<?php
            if ($up === "settings") {
                echo " active";
            }
            ?>">Einstellungen</a>
        </div>
    </div>

    <div class="col-md-9">
        <div class="alert alert-success" role="alert" id="info_success" style="display: none"></div>
        <div class="alert alert-danger" role="alert" id="info_error" style="display: none"></div>
        <?php
        switch ($up) {
            case "users":
                ?>
                <!-- Anfang Benutzer Verwaltung -->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="usr">Name:</label>
                            <input type="text" class="form-control" id="usr">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="pwd">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button type="button" class="btn btn-primary" id="insert_user">Benutzer erstellen</button>
                    </div>
                </div>
                </br>
                </br>
                </br>
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Benutzername</th>
                                <th>Rank</th>
                                <th>Verwalten</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $reqp = $DB->query("SELECT * FROM users");
                            if ($reqp == NULL) {
                                ?>
                                <tr>
                                    <td></td>
                                    <td>Keine Benutzer vorhanden!</td>
                                    <td></td>
                                </tr>
                                <?php
                            } else {
                                foreach ($reqp as $ent) {
                                    ?>
                                    <tr>
                                        <td><?php echo $ent["name"]; ?></td>
                                        <td><?php echo $ent["rank"]; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm edit-btn" where="<?php echo $ent["name"]; ?>" rank="<?php echo $ent["rank"]; ?>">
                                                <span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Beabeiten
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm delete-btn" where="<?php echo $ent["name"]; ?>">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Löschen
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="edit-modal">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="form-group">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Nutzer bearbeiten</h4>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="modal-name" class="control-label">Nutzername</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input class="form-control" id="modal-name" type="text" placeholder="Unknown Username" disabled>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select class="form-control" id="modal-rank">
                                                <option>admin</option>
                                                <option>user</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="modal-save">Speichern</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript" src="js/admin_users.js"></script>
                <!-- Ende der Benutzer Verwaltung -->
                <?php
                break;

            case "log":
                ?>
                <div class="row">
                    <center>
                        <div class="jumbotron" style="height: 550px">
                            <textarea id="console" style="background:transparent; position:relative; width: 100%; height: 100%" disabled>Ganz Ganz viel Text für den Log!</textarea>
                        </div>
                    </center>
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" id="refresh">
                            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Aktuallisieren
                        </button>
                    </div>
                </div>
                <script type="text/javascript" src="js/admin_log.js"></script>
                <?php
                break;

            case "settings":
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        $reqp = $DB->query("SELECT * FROM settings");
                        foreach ($reqp as $ent) {
                            ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="label_set" class="control-label"><?php echo $ent["settingname"]; ?></label>
                                </div>
                                <div class="col-sm-8">
                                    <input class="form-control settings_value" settingname="<?php echo $ent["settingname"]; ?>" id="label_set" type="text" placeholder="Unknown Object" value="<?php echo $ent["value"]; ?>">
                                </div>
                            </div>
                            <hr>
                            <?php
                        }
                        ?>
                        <div class="pull-right">
                            <button type="button" class="btn btn-default" id="save-settings">
                                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Speichern
                            </button>
                        </div>
                    </div>
                </div>
                <script type="text/javascript" src="js/admin_settings.js"></script>
                <?php
                break;
        }
        ?>
    </div>
</div>