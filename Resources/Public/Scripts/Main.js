$(document).ready(function() {
    var localStorage = new window.Basil({
        namespace: 'Famelo.Coff',
        storages: ['local']
    });

    var pki = forge.pki;
    var privateKey = pki.decryptRsaPrivateKey(localStorage.get('privateKey'), 'password');
    var publicKey = pki.setRsaPublicKey(privateKey.n, privateKey.e);

    $('.form-private-key').submit(function(e){
        localStorage.set('privateKey', $('.form-control-private-key').val());
        $('.form-control-private-key').remove();

        var pki = forge.pki;
        var privateKey = pki.decryptRsaPrivateKey($('.form-control-private-key').val(), 'password');
        var publicKey = pki.setRsaPublicKey(privateKey.n, privateKey.e);

        $('.encrypted').each(function(){

            var encrypted = publicKey.encrypt('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.', 'RSA-OAEP');

            e.preventDefault();
        });
    });
    $('.form-control-private-key').val(localStorage.get('privateKey')).removeAttr('name');

    // $('form').submit(function(e){
    //     var pki = forge.pki;
    //     var privateKey = pki.decryptRsaPrivateKey(localStorage.get('privateKey'), 'password');
    //     var publicKey = pki.setRsaPublicKey(privateKey.n, privateKey.e);

    //     $('input.encrypted, textarea.encrypted').each(function(){
    //         var encrypted = publicKey.encrypt($(this).val());
    //         $(this).val(forge.util.encode64(encrypted));
    //     });
    // });


    var pki = forge.pki;
    var privateKey = pki.decryptRsaPrivateKey(localStorage.get('privateKey'), 'password');
    var publicKey = pki.setRsaPublicKey(privateKey.n, privateKey.e);

    $('input.encrypted, textarea.encrypted').each(function(){
        if ($(this).val().length == 0) {
            return;
        }
        var decrypted = privateKey.decrypt(forge.util.decode64($(this).val()));
        $(this).val(decrypted);
    });

    function encryptData(data) {
        if (data.length == 0) {
            return data;
        }

        var key = forge.random.getBytesSync(16);
        var iv = forge.random.getBytesSync(16);

        var aesKeypair = JSON.stringify({
            'key': forge.util.encode64(key),
            'iv': forge.util.encode64(iv)
        });

        var cipher = forge.cipher.createCipher('AES-CBC', key);
        cipher.start({iv: iv});
        cipher.update(forge.util.createBuffer(data));
        cipher.finish();
        var encrypted = cipher.output;

        return {
            'data': forge.util.encode64(cipher.output.data),
            'keypair':  forge.util.encode64(publicKey.encrypt(aesKeypair))
        }
    }

    function decryptData(data, key) {
        if (data.length == 0) {
            return data;
        }

        key = privateKey.decrypt(forge.util.decode64(key));

        GibberishAES.size(256);
        return GibberishAES.dec(data, key);
    }

    var elements = document.querySelectorAll('.editable'),
    editor = new MediumEditor(elements, {
        disablePlaceholders: true
    });

    $('[data-add]').click(function(e){
        var type = $(this).attr('data-add');
        var uri = $(this).attr('data-uri');

        $.post(uri, { 'type': type } ).done(function( data ) {
            $('.parts').append(data);
            var elements = document.querySelectorAll('.editable'),
            editor = new MediumEditor(elements, {
                disablePlaceholders: true
            });
        }).fail(function() {
            alert( "error" );
        });
        e.preventDefault();
    });

    $('.part').on('input', function(e){
        var part = $(this);
        var data = {};
        $(this).find('.editable').each(function(){
            data[$(this).attr('name')] = $(this).html()
        });

        var encrypted = encryptData(JSON.stringify(data));
        var uri = $(this).attr('data-uri');

        $.post(uri, {data: JSON.stringify(data)} ).done(function( data ) {
        }).fail(function() {
            alert( "error" );
        });
        e.preventDefault();
    });

    $('.part').each(function(){
        var part = $(this);
        var keypair = part.attr('data-keypair');
        var data = JSON.parse(decryptData(part.attr('data-data'), keypair));
        $.each(data, function(name){
            part.find('[name="' + name + '"]').html(data[name]);
        })
    });
});