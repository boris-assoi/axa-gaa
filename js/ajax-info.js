/*!
 * Copyright 2019 PURINE CONSULTING
 * Licensed under PURINE CONSULTING Software license
 */

$(document).ready(function () {
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
    let waranties = [];

    //Tableaux de garanties par formule
    var f_all = ['rc', 'dr', 'ra', 'secu', 'vol_ma', 'vol_accessoires', 'van', 'incendie', 'bg', 'im', 'dommage'];
    var f_t_base = ['rc', 'dr', 'ra'];
    var f_t_simple = ['rc', 'dr', 'ra', 'secu'];
    var f_t_ameliore = ['rc', 'dr', 'ra', 'secu', 'vol_ma', 'vol_accessoires', 'van', 'incendie'];
    var f_t_complet = ['rc', 'dr', 'ra', 'secu', 'vol_ma', 'vol_accessoires', 'van', 'incendie', 'bg'];
    var f_tc_complete = ['rc', 'dr', 'ra', 'secu', 'vol_ma', 'vol_accessoires', 'van', 'incendie', 'bg', 'im', 'dommage'];
    var f_tc_collision = ['rc', 'dr', 'ra', 'secu', 'vol_ma', 'vol_accessoires', 'van', 'incendie', 'bg', 'im', 'dommage'];

    //Affichage des champs selon les formules
    $('input[name=formule]').click(function afficherGaranties() {
        //Initialisation des formules
        for (let index = 0; index < f_all.length; index++) {
            $('#' + f_all[index]).css("display", "none");
        }

        //Fonction d'affichage des champs
        /* 
        *@param {Array} formula le tableau comprenant la liste des garanties pour cette formule
        */
        function showFormula(formula) {
            for (let index = 0; index < formula.length; index++) {
                $('#' + formula[index]).css("display", "block");

            }
        }

        //Affichage
        switch ($(this).val()) {
            case 't-base':
                showFormula(f_t_base);
                break;

            case 't-simple':
                showFormula(f_t_simple);
                break;

            case 't-ameliore':
                showFormula(f_t_ameliore);
                break;

            case 't-complet':
                showFormula(f_t_complet);
                break;

            case 'tc-complete':
                showFormula(f_tc_complete);
                break;

            case 'tc-collision':
                showFormula(f_tc_collision);
                break;

            default:
                break;
        }
    })

    //Calcul des garanties
    inView('#step-5').on('enter', function calculGaranties() {
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
            data: {
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
            dataType: "json",
            success: function (data) {
                waranties = data;
                $('#prime_rc').html(waranties["rc"].value);
                $('#prime_ra').html(waranties["ra"].value);
                $('#prime_vol_ma').html(waranties["vol_ma"].value);
                $('#prime_van').html(waranties["van"].value);
                $('#prime_im').html(waranties["im"].value);

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
        if ($(this).is(':checked')) {
            var defense = $(this).val();
            var type = 'opt_defense_recours';
            $.ajax({
                url: "inc/quotation_options.php",
                method: "JSON",
                data: { defense: defense, type: type },
                dataType: "text",
                success: function (data) {
                    waranties = Object.assign(waranties, data);
                    $('#prime_dr').html(waranties["dr"].value);
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
                waranties = Object.assign(waranties, data);
                $('#prime_sr').html(waranties["sr"].value);
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
                waranties = Object.assign(waranties, data);
                $('#prime_bg').html(waranties["bg"].value);
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
                waranties = Object.assign(waranties, data);
                $('#prime_vol_acc').html(waranties["vol_acc"].value);
            }
        });
    });

    /* 
    * Affichage du résumé des ventes
    */
    inView('#step-6').on('enter', function displaySummary() {
        //Initialisation du tableau des garanties
        $('#summary_waranties').empty();

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
        $('#sum_police_duration').html(poltime + " Jours");

        //Formule
        $('#sum_formula').html(formule);

        /**
        * Fonction d'affichage des résumés de garanties
        * @param    {JSON}  warants    Tableau des résultats de calculs des garanties
        * @param    {Array} formula    Tableau de garanties dans une formule
        */
        function showWarantiesResults(warants, formula) {
            let warantieFiltered = JSON.stringify(warants, formula);
            let warantiesParsed = JSON.parse(warantieFiltered);
            console.log(warantiesParsed.length);
            for (let index = 0; index < formula.length; index++) {
                $('#summary_waranties').append(
                    '<tr id="summary_' + formula[index] + '"><td>' + "OPTION" + '</td><td>' + + '</td><td>' + + '</td></tr >'
                );
            }
        }

        /** 
        * Fonction réalisant le filtre du tableau des résultats de garantie et les affichant
        * @param    {JSON}  warants    Tableau des résultats de calculs des garanties
        * @param    {Array} formula    Tableau de garanties dans une formule
        */
        function resultatFormule(warants, formula) {
            var warantieFiltered = [];
            for (let index = 0; index < warants.length; index++) {
                var obj = warants;
                //Tri avec le tableau des formules
                for (let index = 0; index < formula.length; index++) {
                    warantieFiltered.push(obj);
                }
            }
            console.log(warantieFiltered);
            for (let index = 0; index < formula.length; index++) {
                $('#summary_waranties').append(
                    '<tr id="summary_' + formula[index] + '"><td>' + "OPTION" + '</td><td>' + + '</td><td>' + + '</td></tr >'
                );
            }
        }

        /**
        * Fonction réalisant le filtre du tableau des résultats de garantie et les affichant
        * @param    {JSON}  warants    Tableau des résultats de calculs des garanties
        * @param    {Array} formula    Tableau de garanties dans une formule
        */
       function resultat(warants, formula){
            var warantieFiltered = jQuery.grep(warants, function(n,i){
                return n == formula[i];
            });
            console.log(warantieFiltered);
            for (let index = 0; index < formula.length; index++) {
                $('#summary_waranties').append(
                    '<tr id="summary_' + warantieFiltered + '"><td>' + "OPTION" + '</td><td>' + + '</td><td>' + + '</td></tr >'
                );
            }
        }

        /**
        * Fonction réalisant le filtre du tableau des résultats de garantie et les affichant
        * @param    {JSON}  warants    Tableau des résultats de calculs des garanties
        * @param    {Array} formula    Tableau de garanties dans une formule
        */
        function showResults(warants, formula) {
            var warantieFiltered = $.fn.filterJSON(warants,{
                property: "lib",
                wrapper : true,
                value: formula,
                    checkContains: false,
                    startsWith: true,
                    matchCase: true,
                    avoidDuplicates: true
            });

            for (let index = 0; index < formula.length; index++) {
                $('#summary_waranties').append(
                    '<tr id="summary_' + warantieFiltered[lib] + '"><td>' + warantieFiltered[name] + '</td><td>' + warantieFiltered[value] + '</td><td>' + warantieFiltered[option] + '</td></tr >'
                );
            }
        }

        //Tableau des garanties
        switch (formule) {
            case 't-base':
                showResults(waranties, f_t_base);
                break;

            case 't-simple':
                showResults(waranties, f_t_simple);
                break;

            case 't-ameliore':
                showResults(waranties, f_t_ameliore);
                break;

            case 't-complet':
                showResults(waranties, f_t_complet);
                break;

            case 'tc-complete':
                showResults(waranties, f_tc_complete);
                break;

            case 'tc-collision':
                showResults(waranties, f_tc_collision);
                break;

            default:
                break;
        }

        //Ajout de la ligne du total
        $('#summary_waranties').append(
            '<tr id="summary_total"><td colspan="2" class="info">Total</td><td>' + waranties.rc.value + '</td></tr >'
        );
    });

});