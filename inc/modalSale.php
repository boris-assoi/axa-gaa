<!-- Modal Sale -->
                                                <div class="modal fade" id="modalTest" tabindex="-1" role="dialog" aria-labelledby="modalTestLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title text-uppercase" id="modalTestLabel">Vente de police</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <!-- Smart Wizard HTML -->
                                                        <div id="smartwizard">
                                                            <ul>
                                                                <li><a href="#step-1">Souscripteur<br /><small>Détails du souscripteur</small></a></li>
                                                                <li><a href="#step-2">Police<br /><small>Détails de la police</small></a></li>
                                                                <li><a href="#step-3">Véhicule<br /><small>Détails sur le véhicule</small></a></li>
                                                                <li><a href="#step-4">Formule<br /><small>Choix de la formule</small></a></li>
                                                                <li><a href="#step-5">Détails de la formule<br /><small>Compléments de la formule</small></a></li>
                                                                <li><a href="#step-6">Résumé<br /><small>Détails de la vente</small></a></li>
                                                            </ul>

                                                            <div>
                                                                <div id="step-1" class="">
                                                                    <div class="form-group"> 
                                                                        <select id="typAtt" name="typAtt" class="flex-container text-uppercase"> 
                                                                            <?php
                                                                                $request="SELECT type_attestation_lib FROM type_attestation ORDER BY type_attestation_lib ASC";
                                                                                $req = $bdd->query($request);
                                                                                while ($ok = $req->fetch())
                                                                                {
                                                                                    echo "<option class=\"text-uppercase\">".htmlspecialchars($ok['type_attestation_lib'])."</option>";    
                                                                                }
                                                                                $req->closeCursor();
                                                                            ?> 
                                                                        </select>
                                                                        <label class="text-input">
																			<?php
																				$req  = $bdd->prepare($models['dispoAuto']);
																				$req -> execute(array($_SESSION['userID']));
																				$ok = $req->fetch();
																				echo "<span class=\"badge alert-default text-uppercase\">Automobile : ".htmlspecialchars($ok['nbre'])."</span>";
																				$req->closeCursor();
																			?>
																			<?php
																				$req  = $bdd->prepare($models['dispoBrune']);
																				$req -> execute(array($_SESSION['userID']));
																				$ok = $req->fetch();
																				echo "<span class=\"badge alert-warning text-uppercase\">Brune CEDEAO: ".htmlspecialchars($ok['nbre'])."</span>";
																				$req->closeCursor();
																			?>
																			<?php
																				$req  = $bdd->prepare($models['dispoVerte']);
																				$req -> execute(array($_SESSION['userID']));
																				$ok = $req->fetch();
																				echo "<span class=\"badge alert-success text-uppercase\">Carte Verte : ".htmlspecialchars($ok['nbre'])."</span>";
																				$req->closeCursor();
																			?>
																		</label>                                                        
                                                                    </div> 
                                                                    <fieldset>
                                                                        <legend class="text-uppercase">Informations du client</legend>                                               
                                                                        <div class="flex-container">
                                                                            <div class="form-group">                                                
                                                                                <select name="typelient" id="typeClient"> 
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
                                                                                <label class="text-input">Type de client</label>
                                                                            </div>
                                                                            <div class="form-group">                                                     
                                                                                <input type="text" name="nomClient" id="nomClient">      
                                                                                <label class="text-input">Nom et prénoms</label>    
                                                                            </div>
                                                                        </div>        
                                                                        <select id="classe-permis" class="text-uppercase" name="classe_permis">
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
                                                                        <label class="text-input">Classe d'ancienneté</label>
                                                                        <div class="alert alert-info alert-dismissable">
                                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                            <i class="fa fa-info-circle"></i>  <strong id="classe-desc"></strong> <a href="#" class="alert-link"></a>
                                                                        </div>
                                                                        <select id="statut-pro" class="text-uppercase" name="statut-pro">
                                                                            <?php
                                                                            $request='SELECT lib FROM statut_socio_pro';
                                                                            $req = $bdd->query($request);
                                                                            while ($ok = $req->fetch())
                                                                            {
                                                                                echo "<option class=\"\">".htmlspecialchars($ok['lib'])."</option>";
                                                                            }
                                                                            $req->closeCursor();                        
                                                                        ?> 
                                                                        </select>
                                                                        <label class="text-input">Statut socio-professionnel</label>
                                                                        <div class="alert alert-info alert-dismissable">
                                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                            <i class="fa fa-info-circle"></i>  <strong id="statut-desc"></strong> <a href="#" class="alert-link"></a>
                                                                        </div>
                                                                        <div class="flex-container">
                                                                            <div class="form-group">
                                                                                <input type="text" name="pro" id="pro">
                                                                                <label class="text-input">Profession</label>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input type="text" name="adresse" id="adresse">
                                                                                <label class="text-input">Adresse</label>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input type="text" name="contact" id="contact"> 
                                                                                <label class="text-input">Contact</label>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div id="step-2" class="">
                                                                    <fieldset>
                                                                        <legend>Informations sur la police</legend>                                                  
                                                                        <div class="flex-container">
                                                                            <div class="form-group">                                                         
                                                                                <input type="text" name="pol" maxlength="10" id="pol">
                                                                                <label class="text-input">Police N°</label>
                                                                            </div>
                                                                            <div class="form-group">                                                         
                                                                                <input type="date" name="poldf" id="poldf">
                                                                                <label class="text-input">Date de début de la police</label>
                                                                            </div>
                                                                            <div class="form-group">                                                         
                                                                                <input type="number" name="poltime" id="poltime"> 
                                                                                <label class="text-input">Durée de la police (jours)</label>
                                                                            </div>
                                                                            <div class="form-group">                                                         
                                                                                <input type="text" name="poldt" id="poldt" disabled>
                                                                                <label class="text-input">Date de fin de la police</label>
                                                                            </div>
                                                                        </div> 
                                                                    </fieldset>
                                                                </div>
                                                                <div id="step-3" class="">
                                                                    <fieldset>
                                                                        <legend>Informations du véhicule</legend>
                                                                            <div>
                                                                                <select id="catcar" class="text-uppercase" name="cat">
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
                                                                                <label class="text-input">Catégorie</label>
                                                                                <div class="alert alert-info alert-dismissable">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                                    <i class="fa fa-info-circle"></i>  <strong id="cat-desc"></strong> <a href="#" class="alert-link"></a> 
                                                                                </div>   
                                                                            </div> 
                                                                            <select class="text-uppercase" name="carGenre" id="carGenre">
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
                                                                            <label class="text-input">Genre</label>
                                                                            <div class="flex-container">
                                                                                <div class="form-group">                                                         
                                                                                    <input type="text" name="carMake"  id="carMake"> 
                                                                                    <label class="text-input">Marque</label>
                                                                                </div>
                                                                                <div class="form-group">                                                         
                                                                                    <input type="text" name="imat" id="imat"> 
                                                                                    <label class="text-input">Numéro d'immatriculation</label>
                                                                                </div>
                                                                                <div class="form-group">                                                         
                                                                                    <input type="text" name="chassis" id="chassis"> 
                                                                                    <label class="text-input">Numéro de chassis</label>
                                                                                </div>
                                                                                <div class="form-group">                                                         
                                                                                    <input type="date" name="dateCirc" id="dateCirc"> 
                                                                                    <label class="text-input">Date de mise en circulation</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="flex-container">                                              
                                                                                <div class="form-group">                                                   
                                                                                    <select id="pf" name="pf">
                                                                                        <option>Essence</option>                                                         
                                                                                        <option>Diesel</option>                                                         
                                                                                    </select>
                                                                                    <label class="text-input">Type de puissance fiscale</label>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input type="number" id="pfValue" name="pfValue" >
                                                                                    <label class="text-input">Puissance fiscale</label>
                                                                                </div> 
                                                                                <div class="form-group"> 
                                                                                    <input type="text" name="valCat" id="valCat"> 
                                                                                    <label class="text-input">Valeur catalogue </label>                                             
                                                                                </div> 
                                                                                <div class="form-group"> 
                                                                                    <input type="text" name="valVen" id="valVen" disabled> 
                                                                                    <label class="text-input">Valeur vénale</label>                                             
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input type="checkbox" value="rem" id="rem" name="rem">
                                                                                    <label class="text-input">Remorque</label>                                         
                                                                                </div>
                                                                            </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div id="step-4" class="">
                                                                    <div class="flex-container">
                                                                        <div class="form-group">
                                                                            <input type="radio" value="t-base" id="t-base" name="formule">
                                                                            <label class="text-input">Tiers de base</label>                                         
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="radio" value="t-simple" id="t-simple" name="formule">
                                                                            <label class="text-input">Tiers simple</label>                                         
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="radio" value="t-complet" id="t-complet" name="formule">
                                                                            <label class="text-input">Tiers complet</label>                                         
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="radio" value="t-ameliore" id="t-ameliore" name="formule">
                                                                            <label class="text-input">Tiers amélioré</label>                                         
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="radio" value="tc-complete" id="tc-complete" name="formule">
                                                                            <label class="text-input">Tierce complète</label>                                         
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="radio" value="tc-collision" id="tc-collision" name="formule">
                                                                            <label class="text-input">Tierce collision</label>                                         
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="step-5" class="">
                                                                    <!-- Détails de la garantie RESPONSABILITE CIVILE -->
                                                                    <div class="flex-container" id="rc" style="display: none">
                                                                        <fieldset>
                                                                            <legend>Responsabilité civle</legend>
                                                                            <div class="form-group">
                                                                                <label class="text-input">Prime : <span class="primePrint" id="prime_rc"></span></label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <!-- Détails de la garantie DEFENSE ET RECOURS -->
                                                                    <div class="flex-container" id="dr" style="display: none">
                                                                        <fieldset>
                                                                            <legend id="testAffiche">Défense et recours</legend>
                                                                            <div class="form-group">
                                                                                <input type="checkbox" value="1" id="defense" name="defense">
                                                                                <label class="text-input">Garantie tierce complète ou tierce collision</label>                                         
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-input">Prime : <span class="primePrint" id="prime_dr"></span></label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <!-- Détails de la garantie REMBOURSEMENT ANTICIPE -->
                                                                    <div class="flex-container" id="ra" style="display: none">
                                                                        <fieldset>
                                                                            <legend>Remboursement anticipé</legend>
                                                                            <div class="form-group">
                                                                                <label class="text-input">Prime : <span class="primePrint" id="prime_ra"></span></label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <!-- Détails de la garantie  -->
                                                                    <div class="flex-container" id="bg" style="display: none">
                                                                        <fieldset>
                                                                            <legend>Bris de glace</legend>
                                                                            <div class="form-group">
                                                                                <select name="bris" id="bris" class="text-uppercase">
                                                                                    <?php
                                                                                        $request='SELECT id, lib FROM option_g_bri_gla';
                                                                                        $req = $bdd->query($request);
                                                                                        while ($ok = $req->fetch())
                                                                                        {
                                                                                            echo "<option class=\"\" value=\"".htmlspecialchars($ok['id'])."\">".htmlspecialchars($ok['lib'])."</option>";    
                                                                                        }
                                                                                        $req->closeCursor();                        
                                                                                    ?> 
                                                                                </select>
                                                                                <label class="text-input">Options de la garantie</label>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-input">Prime : <span class="primePrint" id="prime_bg"></span></label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <!-- Détails de la garantie VOL ET VOL A MAIN ARMEE -->
                                                                    <div class="flex-container" id="vol_ma" style="display: none">
                                                                        <fieldset>
                                                                            <legend>Vol et vol à main armée</legend>
                                                                            <div class="form-group">
                                                                                <label class="text-input">Prime : <span class="primePrint" id="prime_vol_ma"></span></label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <!-- Détails de la garantie VOL D'ACCESSOIRES -->
                                                                    <div class="flex-container" id="vol_acc" style="display: none">
                                                                        <fieldset>
                                                                            <legend>Vol d'accessoires, autoradio et climatiseur </legend>
                                                                            <div class="flex-container">
                                                                                <div class="form-group">
                                                                                    <select name="option_vol_acc" id="option_vol_acc" class="text-uppercase">
                                                                                        <?php
                                                                                            $request='SELECT id, assiette FROM g_vol_acc';
                                                                                            $req = $bdd->query($request);
                                                                                            while ($ok = $req->fetch())
                                                                                            {
                                                                                                echo "<option class=\"\" value=\"".htmlspecialchars($ok['id'])."\">".htmlspecialchars($ok['assiette'])."</option>";   
                                                                                            }
                                                                                            $req->closeCursor();                       
                                                                                        ?>
                                                                                    </select>
                                                                                    <label class="text-input">Options de la garantie</label>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="text-input">Prime : <span class="primePrint" id="prime_vol_acc"></span></label>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <!-- Détails de la garantie VANDALISME -->
                                                                    <div class="flex-container" id="van" style="display: none">
                                                                        <fieldset>
                                                                            <legend>Vandalisme</legend>
                                                                            <div class="form-group">
                                                                                <label class="text-input">Prime : <span class="primePrint" id="prime_van"></span></label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <!-- Détails de la garantie SECURITE ROUTIERE -->
                                                                    <div class="flex-container" id="sr" style="display: none">
                                                                        <fieldset>
                                                                            <legend>Sécurité routière</legend>
                                                                            <div class="flex-container">
                                                                                <div class="form-group">
                                                                                    <select name="sec_route" id="sec_route" class="text-uppercase">
                                                                                        <?php
                                                                                            $request='SELECT id FROM option_g_sec_rou';
                                                                                            $req = $bdd->query($request);
                                                                                            while ($ok = $req->fetch())
                                                                                            {
                                                                                                echo "<option class=\"\" value=\"".htmlspecialchars($ok['id'])."\"> option ".htmlspecialchars($ok['id'])."</option>";    
                                                                                            }
                                                                                            $req->closeCursor();                        
                                                                                        ?> 
                                                                                    </select>
                                                                                    <label class="text-input">Options de la garantie</label>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="text-input">Prime : <span class="primePrint" id="prime_sr"></span></label>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <!-- Détails de la garantie IMMOBILISATION -->
                                                                    <div class="flex-container" id="im" style="display: none">
                                                                        <fieldset>
                                                                            <legend>Immobilisation</legend>
                                                                            <div class="form-group">
                                                                                <label class="text-input">Prime : <span class="primePrint" id="prime_im"></span></label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <!-- Détails de la garantie VEHICULE DE REMPLACEMENT -->
                                                                    <!-- <div class="flex-container" id="vehicule_remplacement" style="display: none">
                                                                        <fieldset>
                                                                            <legend>Véhicule de remplacement</legend>
                                                                            <div class="flex-container">
                                                                                <div class="form-group">
                                                                                    <select name="option_veh_rem" id="option_veh_rem" class="text-uppercase">
                                                                                        <?php
                                                                                            /* $request='SELECT assiette FROM g_veh_rem';
                                                                                            $req = $bdd->query($request);
                                                                                            while ($ok = $req->fetch())
                                                                                            {
                                                                                                echo "<option class=\"\" value=\"".htmlspecialchars($ok['assiette'])."\"> ".htmlspecialchars($ok['assiette'])."</option>";   
                                                                                            }
                                                                                            $req->closeCursor();  */                       
                                                                                        ?>
                                                                                    </select>
                                                                                    <label class="text-input">Options de la garantie</label>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="text-input">Prime : <span class="primePrint" id="prime_veh_rem"></span></label>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div> -->
                                                                </div>
                                                                <div id="step-6" class="">
                                                                    <div class="panel panel-default summary">
                                                                        <div class="panel-heading">
                                                                            <legend>Résumé de la vente</legend>
                                                                        </div>
                                                                        <div class="panel-body">
                                                                            <div class="panel panel-default">
                                                                                <div class="panel-heading">
                                                                                    <legend>Identification du souscripteur</legend>
                                                                                </div>
                                                                                <div class="panel-body">
                                                                                    <label class="text-input">Nom et prénoms : <span class="summary_details" id="sum_nom"></span></label>
                                                                                    <label class="text-input">Statut socioprofessionnel : <span class="summary_details" id="sum_statut"></span></label>
                                                                                    <label class="text-input">Téléphone : <span class="summary_details" id="sum_tel"></span></label>
                                                                                    <label class="text-input">Adresse : <span class="summary_details" id="sum_address"></span></label>
                                                                                    <label class="text-input">Classe d'ancienneté : <span class="summary_details" id="sum_drive_age"></span></label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="panel panel-default">
                                                                                <div class="panel-heading">
                                                                                    <legend>Identification du véhicule</legend>
                                                                                </div>
                                                                                <div class="panel-body">
                                                                                    <label class="text-input">Usage du véhicule : <span class="summary_details" id="sum_category"></span></label>
                                                                                    <label class="text-input">Immatriculation : <span class="summary_details" id="sum_imat"></span></label>
                                                                                    <label class="text-input">Energie : <span class="summary_details" id="sum_energy"></span></label>
                                                                                    <label class="text-input">Puissance fiscale : <span class="summary_details" id="sum_pfValue"></span></label>
                                                                                    <label class="text-input">Marque : <span class="summary_details" id="sum_carMake"></span></label>
                                                                                    <label class="text-input">Numéro de châssis : <span class="summary_details" id="sum_chassis"></span></label>
                                                                                    <label class="text-input">Charge utile : <span class="summary_details"></span></label>
                                                                                    <label class="text-input">Date de mise en circulation : <span class="summary_details" id="sum_dateCirc"></span></label>
                                                                                    <label class="text-input">Valeur neuve : <span class="summary_details" id="sum_price_new"></span></label>
                                                                                    <label class="text-input">Valeur vénale : <span class="summary_details" id="sum_price_ven"></span></label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="panel panel-default">
                                                                                <div class="panel-heading">
                                                                                    <legend>Détails de la police</legend>
                                                                                </div>
                                                                                <div class="panel-body">
																					<label class="text-input">Numéro de police : <span class="summary_details" id="sum_police_num"></span></label>
                                                                                    <label class="text-input">Effet : <span class="summary_details" id="sum_police_start"></span></label>
                                                                                    <label class="text-input">Echéance : <span class="summary_details" id="sum_police_end"></span></label>
                                                                                    <label class="text-input">Durée de la police : <span class="summary_details" id="sum_police_duration"></span></label>
																				</div>
                                                                            </div>
                                                                            <div class="panel panel-default">
                                                                                <div class="panel-heading">
                                                                                    <legend>Détails de la formule</legend>
                                                                                </div>
                                                                                <div class="panel-body">
																					<label class="text-input">Formule : <span class="summary_details" id="sum_formula"></span></label>
																					<div class="table-responsive">
																						<table class="table table-bordered table-hover table-striped">
																							<thead>
																								<tr>
                                                                                                    <th>N°</th>
																									<th>Garantie</th>
																									<th>Option</th>
																									<th>Prime</th>
																								</tr>
																							</thead>
																							<tbody id="summary_waranties" class="text-uppercase">
                                                                                                <tr id="summary_total">
                                                                                                    <td colspan="3" class="info">Total</td>
                                                                                                    <td></td>
                                                                                                </tr>
																							</tbody>
																						</table>
																					</div>
																				</div>
                                                                            </div>
                                                                            <button class="btn btn-info"><i class="fa fa-fw fa-print"></i> Note de couverture</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>