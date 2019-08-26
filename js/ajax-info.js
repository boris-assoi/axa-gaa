/*!
 * Copyright 2019 PURINE CONSULTING
 * Licensed under PURINE CONSULTING Software license
 */

$(document).ready(function () {
    //Initialisation des champs
    inView('#step-1').on('enter', function initFields() {
        var classe = $('#classe-permis').val();
        var spro = $('#statut-pro').val();
        var catcar = $('#catcar').val();
        $.ajax({
            url: "inc/fetch_data.php",
            method: "POST",
            data: {
                classe: classe,
                type: "cls-pc"
            },
            dataType: "text",
            success: function (data) {
                $('#classe-desc').html(data);
            }
        });
        $.ajax({
            url: "inc/fetch_data.php",
            method: "POST",
            data: { stat: spro, type: "socio-pro" },
            dataType: "text",
            success: function (data) {
                $('#statut-desc').html(data);
            }
        });
        $.ajax({
            url: "inc/fetch_data.php",
            method: "POST",
            data: { cat: catcar, type: "cat" },
            dataType: "text",
            success: function (data) {
                $('#cat-desc').html(data);
                $('#sum_category').html(data);
            }
        });
    });
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
                $('#sum_category').html(data);
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

    //Variable contenant le total des primes de garanties
    let totalFormula;

    //Variable contenant les informations de la souscription
    let info;

    //Tableaux de garanties par formule
    var f_all = ['rc', 'dr', 'ra', 'sr', 'vol_ma', 'vol_acc', 'van', 'inc', 'bg', 'im'];
    var f_t_base = ['rc', 'dr', 'ra'];
    var f_t_simple = ['rc', 'dr', 'ra', 'sr'];
    var f_t_ameliore = ['rc', 'dr', 'ra', 'sr', 'vol_ma', 'vol_acc', 'van', 'inc'];
    var f_t_complet = ['rc', 'dr', 'ra', 'sr', 'vol_ma', 'vol_acc', 'van', 'inc', 'bg'];
    var f_tc_complete = ['rc', 'dr', 'ra', 'sr', 'vol_ma', 'vol_acc', 'van', 'inc', 'bg', 'im'];
    var f_tc_collision = ['rc', 'dr', 'ra', 'sr', 'vol_ma', 'vol_acc', 'van', 'inc', 'bg', 'im'];

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

    //Calcul de la prime de garantie srURITE ROUTIERE
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

        //Initialisation des champs des valeurs supplémentaires
        $('#sup_pcost').empty();
        $('#sup_tax').empty();
        $('#sup_fnd').empty();
        $('#sup_cbcost').empty();
        $('#sup_total').empty();

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

        info = {
            "typAtt": typAtt,
            "typeClient": typeClient,
            "nomClient": nomClient,
            "classe_permis": classe_permis,
            "status_pro": statut_pro,
            "pro": pro,
            "adresse": adresse,
            "contact": contact,
            "pol": pol,
            "poldf": poldf,
            "poldt": poldt,
            "poltime": poltime,
            "catcar": catcar,
            "carGenre": carGenre,
            "carMake": carMake,
            "imat": imat,
            "chassis": chassis,
            "dateCirc": dateCirc,
            "pf": pf,
            "pfValue": pfValue,
            "valCat": valCat,
            "valVen": valVen,
            "rem": rem,
            "formule": formule
        }

        //Souscripteur
        $('#sum_nom').html(nomClient);
        $('#sum_statut').html(statut_pro);
        $('#sum_tel').html(contact);
        $('#sum_address').html(adresse);
        $('#sum_drive_age').html(classe_permis);

        //Véhicule
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
        * Fonction réalisant le filtre du tableau des résultats de garantie et les affichant
        * @param    {JSON}      warants         Tableau des résultats de calculs des garanties
        * @param    {Array}     formula         Tableau de garanties dans une formule
        */
        function showResults(warants, formula) {
            var warantieFiltered = {};
            totalFormula = 0;
            warantieFiltered = $.fn.filterJSON(warants, {
                property: "lib",
                wrapper: true,
                value: formula,
                checkContains: false,
                startsWith: true,
                matchCase: true,
                avoidDuplicates: true
            });
            console.log(warantieFiltered);
            for (let index = 0; index < formula.length; index++) {
                totalFormula += parseInt(warantieFiltered[index].value);
                console.log(totalFormula);
                $('#summary_waranties').append(
                    '<tr id="summary_' + warantieFiltered[index].lib + '"><td>' + (index + 1) + '</td><td>' + warantieFiltered[index].name + '</td><td>' + warantieFiltered[index].option + '</td><td>' + warantieFiltered[index].value + '</td></tr >'
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
            '<tr id="summary_net"><td colspan="3" class="info text-right lead">Prime nette</td><td class="lead"><b>' + Math.round(totalFormula) + '</b></td></tr >'
        );

        //CALCUL DES TAXES SUPPLEMENTAIRES
        var sup_pcost, sup_tax, sup_fnd, sup_cbcost, sup_total;

        //Calcul de la valeur du coût de la police
        if (totalFormula < 100000) {
            sup_pcost = 5000;
        }
        if (totalFormula >= 100000 && totalFormula < 500000) {
            sup_pcost = 10000;
        }
        if (totalFormula >= 500000 && totalFormula < 1000000) {
            sup_pcost = 15000;
        }
        if (totalFormula > 1000000) {
            sup_pcost = 20000;
        }

        //Calcul de la valeur des taxes
        sup_tax = Math.round((totalFormula + sup_pcost) * 0.145);

        //Calcul de la valeur du fonds de garantie auto
        sup_fnd = waranties.dr.value * 0.02;

        //Calcul de la valeur de la carte brune
        if (sup_fnd == 0) {
            sup_cbcost = 0;
        } else {
            sup_cbcost = 1000;
        }

        //Calcul du cout total de la prime
        sup_total = totalFormula + sup_pcost + sup_tax + sup_fnd + sup_cbcost;

        //Affichage dans le tableau
        $('#sup_pcost').append(sup_pcost);
        $('#sup_tax').append(sup_tax);
        $('#sup_fnd').append(sup_fnd);
        $('#sup_cbcost').append(sup_cbcost);
        $('#sup_total').append('<b>' + sup_total + '</b>');
    });

});