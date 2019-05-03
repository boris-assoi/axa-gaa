/*!
 * Copyright 2019 Boris Assoi
 * Licensed under DIGITAL PURINE Software license
 */

$(document).ready(function(){
    //Statut socio-professionnel
    $('#statut-pro').change(function afficherInfoStatutPro() {
        var spro = $(this).val();
        var type = 'socio-pro';
        $.ajax({
            url: "inc/fetch_data.php",
            method: "POST",
            data: { stat: spro, type: type },
            dataType: "text",
            success: function (data) {
                $('#statut-desc').html(data);
            }
        });
    });

    //Catégorie
    $('#catcar').change(function afficherInfoCategorieVehicule() {
        var catcar = $(this).val();
        var type = 'cat';
        $.ajax({
            url: "inc/fetch_data.php",
            method: "POST",
            data: { cat: catcar, type: type },
            dataType: "text",
            success: function (data) {
                $('#cat-desc').html(data);
            }
        });
    });

    //Classe du permis de conduire
    $('#classe-permis').change(function afficherInfoClassePermis() {
        var classe = $(this).val();
        var type = 'cls-pc';
        $.ajax({
            url: "inc/fetch_data.php",
            method: "POST",
            data: { classe: classe, type: type },
            dataType: "text",
            success: function (data) {
                $('#classe-desc').html(data);
            }
        });
    });

    //Calcul de la date de fin de la police | Sur le champ de la date du début
    $('#poldf').change(function DateFinPoliceParDateDebut() {
        var poldf = $(this).val();
        var poltime = $('#poltime').val();
        var type = 'echeance-police';
        $.ajax({
            url: "inc/fetch_data.php",
            method: "POST",
            data: { poldf: poldf, poltime: poltime, type: type },
            dataType: "text",
            success: function (data) {
                $('#poldt').val(data);
            }
        });
    });

    //Calcul de la date de fin de la police | Sur le champ de la durée
    $('#poltime').change(function DateFinPoliceParDuree() {
        var poltime = $(this).val();
        var poldf = $('#poldf').val();
        var type = 'echeance-police';
        $.ajax({
            url: "inc/fetch_data.php",
            method: "POST",
            data: { poldf: poldf, poltime: poltime, type: type },
            dataType: "text",
            success: function (data) {
                $('#poldt').val(data);
            }
        });
    });

    //Calcul de la valeur vénale
    $('#valCat').change(function calculValeurVenale() {
        var valCat = $(this).val();
        var dateCirc = $('#dateCirc').val();
        var type = 'valeur-venale';
        $.ajax({
            url: "inc/fetch_data.php",
            method: "POST",
            data: { valCat: valCat, dateCirc: dateCirc, type: type },
            dataType: "text",
            success: function (data) {
                $('#valVen').val(data);
            }
        });
    });

    //Variable contenant les garanties sélectionnées
    var waranties = [];

    //Affichage des champs selon les formules
    $('input[name=formule]').click(function afficherGaranties(){
        switch ($(this).val()) {
            case 't-base':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#bg').css("display", "none");
                $('#dommage').css("display", "none");
                $('#vol_ma').css("display", "none");
                $('#vol_accessoires').css("display", "none");
                $('#van').css("display", "none");
                $('#incendie').css("display", "none");
                $('#secu').css("display", "none");
                $('#im').css("display", "none");
                $('#vehicule_remplacement').css("display", "none");
                break;
        
            case 't-simple':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#bg').css("display", "none");
                $('#dommage').css("display", "none");
                $('#vol_ma').css("display", "none");
                $('#vol_accessoires').css("display", "none");
                $('#van').css("display", "none");
                $('#incendie').css("display", "none");
                $('#secu').css("display", "block");
                $('#im').css("display", "none");
                $('#vehicule_remplacement').css("display", "none");
                break;

            case 't-ameliore':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#bg').css("display", "none");
                $('#dommage').css("display", "none");
                $('#vol_ma').css("display", "block");
                $('#vol_accessoires').css("display", "block");
                $('#van').css("display", "block");
                $('#incendie').css("display", "block");
                $('#secu').css("display", "block");
                $('#im').css("display", "none");
                $('#vehicule_remplacement').css("display", "none");
                break;

            case 't-complet':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#bg').css("display", "block");
                $('#dommage').css("display", "none");
                $('#vol_ma').css("display", "block");
                $('#vol_accessoires').css("display", "block");
                $('#van').css("display", "block");
                $('#incendie').css("display", "block");
                $('#secu').css("display", "block");
                $('#im').css("display", "none");
                $('#vehicule_remplacement').css("display", "none");
                break;

            case 'tc-complete':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#bg').css("display", "block");
                $('#dommage').css("display", "block");
                $('#vol_ma').css("display", "block");
                $('#vol_accessoires').css("display", "block");
                $('#van').css("display", "block");
                $('#incendie').css("display", "block");
                $('#secu').css("display", "block");
                $('#im').css("display", "block");
                $('#vehicule_remplacement').css("display", "none");
                break;

            case 'tc-collision':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#bg').css("display", "block");
                $('#dommage').css("display", "block");
                $('#vol_ma').css("display", "block");
                $('#vol_accessoires').css("display", "block");
                $('#van').css("display", "block");
                $('#incendie').css("display", "block");
                $('#secu').css("display", "block");
                $('#im').css("display", "block");
                $('#vehicule_remplacement').css("display", "block");
                $('#vehicule_remplacement').css("display", "none");
                break;

            default:
                break;
        }
    })

    //Calcul des garanties
    inView('#step-5').on('enter', function calculGaranties(){
        var data;
        var pol = $('#pol').val();
        var poldf = $('#poldf').val();
        var poltime = $('#poltime').val();
        var poldt = $('#poldt').val();
        var catCar = $('#catCar').val();
        var carGenre = $('#carGenre').val();
        var carMake = $('#carMake').val();
        var imat = $('#imat').val();
        var chassis = $('#chassis').val();
        var dateCirc = $('#dateCirc').val();
        var pf = $('#pf').val();
        var pfValue = $('#pfValue').val();
        var valCat = $('#valCat').val();
        var valVen = $('#valVen').val();
        var rem = $('input[name=rem]:checked').val();
        var formule = $('input[name=formule]:checked').val();
        $.ajax({
            url: "testPHP.php",
            method: "POST",
            data:{
                pol: pol,
                poldf: poldf,
                poltime: poltime,
                poldt: poldt,
                catCar: catCar,
                carGenre: carGenre,
                carMake: carMake,
                imat: imat,
                chassis: chassis,
                dateCirc: dateCirc,
                pf: pf,
                pfValue: pfValue,
                valCat: valCat,
                valVen: valVen,
                rem: rem,
                formule: formule
            },
            dataType : "json",
            success: function(data){
                //alert("Test OK");
                waranties = data;
                $('#prime_rc').html(waranties.rc.value);
                $('#prime_ra').html(waranties.ra.value);
                $('#prime_vol_ma').html(waranties.vol_ma.value);
                $('#prime_van').html(waranties.van.value);
                $('#prime_im').html(waranties.im.value);

                console.log(waranties);
            },
            error: function (jqXHR, textStatus) {
                alert('error : Veuillez vérifier les informations saisies');
                console.log(jqXHR); //affichage dans la console du navigateur              
            }
        })
        return data;
        ;
    });
    
    //Calcul de la prime de garantie DEFENSE ET RECOURS
    $('#defense').change(function calculPrimeDR() {
        if($(this).is(':checked')){
            var defense = $(this).val();
            var type = 'opt_defense_recours';
            $.ajax({
                url: "inc/quotation_options.php",
                method: "JSON",
                data: { defense: defense, type: type },
                dataType: "text",
                success: function (data) {
                    waranties += data;
                    $('#prime_dr').html(waranties.dr.value);
                }
            });
        } else {
            $('#prime_dr').html('<span>7950<span>');
        }
    });

    //Calcul de la prime de garantie SECURITE ROUTIERE
    $('#sec_route').change(function calculPrimeSR() {
        var sec_route = $(this).val();
        var poltime = $('#poltime').val();
        var type = 'opt_securite_routiere';
        $.ajax({
            url: "inc/quotation_options.php",
            method: "POST",
            data: {
                sec_route: sec_route,
                poltime: poltime,
                type: type
             },
            dataType: "JSON",
            success: function (data) {
                waranties += data;
                $('#prime_sr').html(waranties.sr.value);
            }
        });
    });

    //Calcul de la prime de garantie BRIS DE GLACE
    $('#bris').change(function calculPrimeBG() {
        var bris = $('#bris').val();
        var valCat = $('#valCat').val();
        var type = 'opt_bris_glace';
        $.ajax({
            url: "inc/quotation_options.php",
            method: "POST",
            data: { bris: bris, valCat: valCat, type: type },
            dataType: "JSON",
            success: function (data) {
                waranties;
                console.log("log : "+waranties);
                $('#prime_bg').html(waranties.bg.value);
            }
        });
    });

    //Calcul de la prime de garantie VOL D'ACCESSOIRES
    $('#option_vol_acc').change(function calculPrimeVolAcc() {
        var option_vol_acc = $(this).val();
        var type = 'opt_vol_accessoires';
        $.ajax({
            url: "inc/quotation_options.php",
            method: "POST",
            data: { option_vol_acc: option_vol_acc, type: type },
            dataType: "JSON",
            success: function (data) {
                waranties += data;
                $('#prime_vol_acc').html(waranties.vol_acc.value);
            }
        });
    });

    /* 
    * Affichage du résumé des ventes
    */
    inView('#step-6').on('enter', function displaySummary() {
        var typAtt = $('#typAtt').val();
        var typeClient = $('#typeClient').val();
        var nomClient = $('#nomClient').val();
        var classe_permis = $('#classe-permis').val();
        var statut_pro = $('#statut-pro').val();
        var pro = $('#pro').val();
        var adresse = $('#adresse').val();
        var contact = $('#contact').val();
        var pol = $('#pol').val();
        var poldf = $('#poldf').val();
        var poltime = $('#poltime').val();
        var poldt = $('#poldt').val();
        var catCar = $('#catCar').val();
        var carGenre = $('#carGenre').val();
        var carMake = $('#carMake').val();
        var imat = $('#imat').val();
        var chassis = $('#chassis').val();
        var dateCirc = $('#dateCirc').val();
        var pf = $('#pf').val();
        var pfValue = $('#pfValue').val();
        var valCat = $('#valCat').val();
        var valVen = $('#valVen').val();
        var rem = $('input[name=rem]:checked').val();
        var formule = $('input[name=formule]:checked').val();

        //Souscripteur
        $('#sum_nom').html(nomClient);
        $('#sum_statut').html(statut_pro);
        $('#sum_tel').html(contact);
        $('#sum_address').html(adresse);
        $('#sum_drive_age').html(classe_permis);

        //Véhicule
        $('#sum_category').html(catCar);
        $('#sum_imat').html(imat);
        $('#sum_energy').html(pf);
        $('#sum_pfValue').html(pfValue);
        $('#sum_carMake').html(carMake);
        $('#sum_chassis').html(chassis);
        $('#sum_dateCirc').html(dateCirc);
        $('#sum_price_new').html(valCat);
        $('#sum_price_ven').html(valVen);

        //Police
        $('#sum_police_num').html(pol);
        $('#sum_police_start').html(poldf);
        $('#sum_police_end').html(poldt);
        $('#sum_police_duration').html(poltime+" Jours");

        //Garantie
        $('#sum_formula').html(formule);
    });

});