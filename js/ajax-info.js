$(document).ready(function(){
    //Statut socio-professionnel
    $('#statut-pro').change(function () {
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
    $('#catcar').change(function () {
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
    $('#classe-permis').change(function () {
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

    //Affichage des champs selon les formules
    $('input[name=formule]').click(function afficherGaranties(){
        switch ($(this).val()) {
            case 't-base':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#sr').css("display", "none");
        
            case 't-simple':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#sr').css("display", "block");
                break;

            case 't-complet':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#sr').css("display", "block");
                break;

            case 't-ameliore':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#sr').css("display", "block");
                break;

            case 'tc-complete':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#sr').css("display", "block");
                break;

            case 'tc-collision':
                $('#rc').css("display", "block");
                $('#dr').css("display", "block");
                $('#ra').css("display", "block");
                $('#sr').css("display", "block");
                break;

            default:
                break;
        }
    })

    //Calcul des garanties
    inView('#step-5').on('enter', function(){
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
        $.ajax({
            url: "testPHP.php",
            method: "POST",
            data:{
                typAtt: typAtt,
                typeClient: typeClient,
                nomClient: nomClient,
                classe_permis: classe_permis,
                statut_pro: statut_pro,
                pro: pro,
                adresse: adresse,
                contact: contact,
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
                console.log('prime : ' + data.prime_rc);
                alert("Test OK");
                $('#prime_rc').html(data.prime_rc);
                $('#prime_dr').html(data.prime_dr);
                $('#prime_ra').html(data.prime_ra);
            },
            error: function (jqXHR, textStatus) {
                alert('error');
                console.log(jqXHR); //affichage dans la console du navigateur              
            }
        });
    })

});