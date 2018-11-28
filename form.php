<form role="form" method="POST" action="inc/cat1_waranties.php"> 
    <div class="form-group"> 
        <label class="control-label" for="formInput28">Sélectionner le type d'attestation</label>                                                         
        <span class="text-uppercase"> <span> - Disponibilité - </span> <?php
            $req  = $bdd->prepare($models['dispoAuto']);
            $req -> execute(array($_SESSION['userID']));
            $ok = $req->fetch();
            echo "Automobile : <span class=\"badge alert-success text-uppercase\">".htmlspecialchars($ok['nbre'])."</span>";
            $req->closeCursor();
            
        ?> <?php
            $req  = $bdd->prepare($models['dispoBrune']);
            $req -> execute(array($_SESSION['userID']));
            $ok = $req->fetch();
            echo "Brune CEDEAO: <span class=\"badge alert-success text-uppercase\">".htmlspecialchars($ok['nbre'])."</span>";
            $req->closeCursor();
            
        ?> <?php
            $req  = $bdd->prepare($models['dispoVerte']);
            $req -> execute(array($_SESSION['userID']));
            $ok = $req->fetch();
            echo "Carte Verte : <span class=\"badge alert-success text-uppercase\">".htmlspecialchars($ok['nbre'])."</span>";
            $req->closeCursor();
            
        ?> </span> 
        <select id="typAtt" class="form-control" name="typAtt"> 
            <?php
            $request="SELECT * FROM type_attestation ORDER BY type_attestation_lib ASC";
            $req = $bdd->query($request);
            while ($ok = $req->fetch())
            {
                echo "<option class=\"text-uppercase\">".htmlspecialchars($ok['type_attestation_lib'])."</option>";    
            }
            $req->closeCursor();
        ?> 
        </select>                                                         
    </div> 
    <fieldset>
        <legend>Informations du client</legend>                                               
        <div class="form-group"> 
            <label class="control-label" for="formInput28">Sélectionner le type de client</label>                                                         
            <select id="formInput28" class="form-control" name="type"> 
                <?php
                $request='SELECT type_client_lib FROM type_client';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['type_client_lib'])."</option>";    
                }
                $req->closeCursor();                        
            ?> 
            </select>                                                         
        </div>                                                     
        <div class="form-group"> 
            <label class="control-label" for="exampleInputPassword1">Nom du client</label>                                                         
            <input type="text" class="form-control" name="nom" placeholder="Entrer le nom du client"> 
        </div>
        <div class="form-group form-inline">              
            <select id="classe-permis" class="form-control text-uppercase" name="classe_permis">
                <option>Sélectionnez la classe d'ancienneté</option>
                <?php
                $request='SELECT lib FROM classe_permis';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";    
                }
                $req->closeCursor();                        
            ?> 
            </select>
            <div class="alert alert-info" id="classe-desc"></div>
            <select id="status-pro" class="form-control text-uppercase" name="status-pro"> 
                <option>Sélectionnez le statut socio-professionnel</option>
                <?php
                $request='SELECT lib, info FROM statut_socio_pro';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                }
                $req->closeCursor();                        
            ?> 
            </select>
            <i class="fa fa-lg fa-question-circle" data-toggle="tooltip" data-placement="auto" title="example" id="info-status-pro"></i>
            <input type="text" class="form-control" placeholder="Profession du client" name="pro"> 
            <input type="text" class="form-control" name="adresse" placeholder="Adresse du client"> 
            <input type="text" class="form-control" name="contact" placeholder="Contact du client"> 
        </div> 
    </fieldset>
    <fieldset>
        <legend>Informations sur la police</legend>                                                  
        <div class="form-group"> 
            <label class="control-label" for="exampleInputPassword1">Police N°</label>                                                         
            <input type="text" class="form-control" name="pol" maxlength="10" placeholder="Entrer le numéro de la police"> 
        </div>                                                     
        <div class="form-group form-inline"> 
            <label class="control-label" for="exampleInputPassword1">Date de début de la police</label>                                                         
            <input type="date" class="form-control" placeholder="Entrer la date de début de la police" name="poldf">
            <label class="control-label" for="exampleInputPassword1">Date de fin de la police</label>                                                         
            <input type="date" class="form-control" placeholder="Entrer la date de fin de la police" name="poldt"> 
        </div> 
    </fieldset>
    <fieldset>
        <legend>Informations du véhicule</legend>                                                 
        <div class="form-group form-inline">
            <select id="catcar" class="form-control text-uppercase" name="cat"> 
            <option>Sélectionnez la catégorie</option>
            <?php
            $request='SELECT cat_vehicule_id FROM categorie_vehicule';
            $req = $bdd->query($request);
            while ($ok = $req->fetch())
            {
                echo "<option class=\"\">".htmlspecialchars($ok['cat_vehicule_id'])."</option>";    
            }
            $req->closeCursor();                        
            ?> 
            </select>                                                         
            <div class="alert alert-info" id="cat-desc"></div>   
            <select id="formInput28" class="form-control text-uppercase" name="carGenre">
                <option>Sélectionnez le genre du véhicule</option>
                <?php
                $request='SELECT type_vehicule_lib FROM type_vehicule';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['type_vehicule_lib'])."</option>";
                }
                $req->closeCursor();                        
            ?> 
            </select>                                                         
            <input type="text" class="form-control" placeholder="Marque" name="carMake"> 
            <input type="text" class="form-control" name="imat" placeholder="Immatriculation"> 
            <input type="text" class="form-control" name="chassis" placeholder="Numéro de chassis"> 
        </div>                                                     
        <div class="form-group form-inline"> 
            <label class="control-label" for="exampleInputPassword1">Puissance fiscale</label><br>                                                     
        <select id="pf" class="form-control" name="pf">
            <option>Sélectionner le type de puissance fiscale</option>
            <option>Essence</option>                                                         
            <option>Diesel</option>                                                         
        </select>
        <select id="pfValue" class="form-control" name="pfValue"> 
            <option>Sélectionnez la puissance fiscale</option>
        </select>
        </div>
        <div class="form-group form-inline"> 
            <label class="control-label">Valeur du véhicule</label> 
            <input type="text" class="form-control" placeholder="Valeur catalogue" name="valCat">                                             
        </div>
        <div class="form-group"> 
            <label class="control-label">Le véhicule possède-t-il une remorque? </label> 
            <input type="checkbox" value="rem" id="rem" name="rem">                                             
        </div>
    </fieldset>
    <fieldset>
        <legend><input type="checkbox" value="def-rec" id="def-rec"> Garantie défense et recours</legend>
        <div class="form-group form-inline"> 
            <select class="form-control text-uppercase" name="defense" id="defense" enable="false">
                <option>Sélectionnez le type de garantie</option>
                <?php
                $request='SELECT lib FROM type_g_def_rec';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                }
                $req->closeCursor();                        
                ?>
            </select>
        </div>
    </fieldset>
    <fieldset>
        <legend><input type="checkbox" value="" id="rem-ant"> Garantie remboursement anticipé</legend>
        <div class="form-group form-inline"> 
            <select class="form-control text-uppercase" name="remb" id="remb">
                <option>Sélectionnez le type de garantie</option>
                <?php
                $request='SELECT lib FROM prime_g_rem_ant';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                }
                $req->closeCursor();                        
                ?>
            </select>
        </div>
    </fieldset>
    <fieldset>
        <legend><input type="checkbox" value="" id="bris-glace"> Garantie bris de glace</legend>
        <div class="form-group form-inline"> 
            <select class="form-control text-uppercase" name="bris" id="bris">
                <option>Sélectionnez l'option de la garantie</option>
                <?php
                $request='SELECT lib FROM option_g_bri_gla';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                }
                $req->closeCursor();                        
                ?>
            </select>
        </div>
    </fieldset>
    <fieldset>
        <legend><input type="checkbox" value="" id="domID"> Garantie dommages</legend>
        <div class="form-group form-inline"> 
            <select class="form-control text-uppercase" name="dom" id="dom">
                <option>Sélectionnez l'option de la garantie</option>
                <?php
                $request='SELECT lib FROM type_g_dom';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                }
                $req->closeCursor();                        
                ?>
            </select>
        </div>
    </fieldset> 
    <fieldset>
        <legend><input type="checkbox" value="" id="secRouID"> Garantie sécurité routière</legend>
        <div class="form-group form-inline"> 
            <select class="form-control text-uppercase" name="sec_rou_cap" id="sec_rou_cap">
                <option>Sélectionnez le capital garanti</option>
                <?php
                $request='SELECT lib FROM capital_garantie_g_sec_rou';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                }
                $req->closeCursor();                        
                ?>
            </select>
            <select class="form-control text-uppercase" name="sec_rou_opt" id="sec_rou_opt">
                <option>Sélectionnez l'option'</option>
                <?php
                $request='SELECT lib FROM option_g_sec_rou';
                $req = $bdd->query($request);
                while ($ok = $req->fetch())
                {
                    echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                }
                $req->closeCursor();                        
                ?>
            </select>
        </div>
    </fieldset>                                    
    <div class="form-group"> 
        <label class="control-label" for="exampleInputPassword1">Montant de la police</label>                                             
        <input type="number" class="form-control" name="amount" placeholder="Entrer le montant"> 
    </div>                                         
    <input type="text" hidden="" value="1" name="vType"> 
    <button type="submit" class="btn btn-success">Vendre</button>                                         
    <a href="JavaScript:window.history.back()" class="hidden-print"> 
        <button type="button" class="btn btn-danger">Annuler</button>                                             
    </a>                                         
</form>