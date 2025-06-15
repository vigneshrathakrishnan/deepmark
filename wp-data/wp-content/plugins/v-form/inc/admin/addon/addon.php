<?php
    defined('ABSPATH') || die("Nice try");
?>
<style>
.vform-addoncont img{
    width:100%;
}
.vform-addoncont ul {
    margin: 0;
    padding: 20px;
    padding-left: 0;
}
.vform-addoncont ul li {
    width: 48%;
    display: inline-block;
    padding: 10px;
    height: 350px;
    overflow: hidden;
}
.vform-addoncont img {
    width: 100%;
    object-fit: contain;
    height: 100%;
    object-position: left;
}
.vf-img1{
    cursor: pointer;
}
</style>
<div class="vform-addoncont">
    <ul>
        <li>
            <img class="vf-img1 vf-showbrevo" src="<?php echo VFORM_PLUGIN_URL."assets/images/addon/brevo-1.jpg"; ?>">
        </li>
        <li>
            <a href="https://get.apollo.io/j5vq1d5b79l5" target="_blank">
                <img class="vf-img1" src="<?php echo VFORM_PLUGIN_URL."assets/images/addon/apollo-1.png"; ?>">
            </a>
        </li>
        <li>
            <a href="https://r.honeygain.me/ONLIN9E579" target="_blank">
                <img class="vf-img1" src="<?php echo VFORM_PLUGIN_URL."assets/images/addon/honey-1.jpg"; ?>">
            </a>
        </li>
        <li>
            <a href="https://get.learnworlds.com/09l1bfmj982y" target="_blank">
                <img class="vf-img1" src="<?php echo VFORM_PLUGIN_URL."assets/images/addon/learn-affiliate.jpg"; ?>">
            </a>
        </li>
    </ul>
</div>

 <!-- free gift -->
 <style>
       .outerpopupvf, .outerpopupvf_createform {
            background: rgb(32 21 21 / 52%);
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100vw;
            height: 100vh;
            display: none;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            z-index: 2000;
        }
        .popup_vf {
            font-family: 'Inter';
            background: #fff;
            color: #000;
            text-align: center;
            padding: 25px;
            border-radius: 8px;
            width: 650PX;
            flex: 1 1 auto !important;      
            display: flex !important;
            flex-flow: column nowrap !important;
            min-width: 550px;
            max-width: 650px;
            max-height: min(650px, -70px + 100vh);
            box-shadow: rgba(0, 0, 0, 0.1) -8px 0px 20px;
            position: relative;
        }
        .popup_vf input {
            width: 100%;
            height: 41px;
            margin-top: 0px;
        }

        .popup_vf .btn {
            width: 120px;
            height: 39px;
            margin-top: 20px;
            cursor: pointer;
            background: #503ebd;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: 600;
        }
        .popbtn {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    column-gap: 20px;
    }
            button.btn.cancelfrm {
        background: #d5d7fc;
        color: #503ebd;
    }
        .popup_vf .crs {
    position: absolute;
    right: 3px;
    top: 5px;
    z-index: 9999;
    cursor: pointer;
    background: #fff;
    border-radius: 50px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    }
        .frmtit{
            text-align:left;
        }
        .popup_vf p {
        font-size: 18px;
        font-weight: 500;
        margin-top: 0px;
    }
    input.vfembtn {
    margin-top: 15px;
    }
    .entremal{
        margin-top:30px;
    }


    ._select_c1fz5_1 {
        flex-direction: column;
        gap: 10px;
        position: relative;
        display: flex;
    }
    ._popover_c1fz5_59{
        position: absolute;
        z-index: 100000;
        max-height: 175px;
        left: 0px;
        top: -119px;
        overflow: auto;
        padding: 7px;
        box-sizing: border-box;
        background-color: #fff;
        box-shadow: 0px 10px 30px 0px rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        width: 135px;
        display: none;
    }
    ._select-item_1ldx3_1 {
        padding: 7px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #413735;
        cursor: pointer;
    }
    ._select-item_1ldx3_1:hover {
        background-color: #f7f6fd;
        color: #503ebd;
    }



</style>
<form id="myvformdata6form">
        <?php wp_nonce_field('myvformdata66','vfm-nonce66'); ?>
</form>
<div class='outerpopupvf'>
    <div class="popup_vf">
        <span class="crs">&#10006;</span>
        <div class="entremal">You will get an invite to your provided email address within 24 hrs and then you can use your free account with 300/day emails.</div>
        <input type="email" placeholder="Email Address" class="vfembtn" >
        <button type="button" class="btn vfrom_brevowaitlist">Submit</button>
        <div class="entremal">If you haven't receive any email contact at: vforminfo@gmail.com</div>
    </div>
</div>

<!-- free gift -->
 <script>
    jQuery(function($){
        $(document).ready(function(){
            
            $('.vf-showbrevo').click(function(){
                $('.outerpopupvf').css('display','flex');
            });

            $('.outerpopupvf .crs').click(function(){
               $('.outerpopupvf').hide();
            });

            $('.vfrom_brevowaitlist').click(function(){
            var getemail = $('.vfembtn').val();

            function validateEmail(email) {
                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return emailPattern.test(email);
            }

            if (validateEmail(getemail)) {
                
                var nonce = $('#myvformdata6form').serialize();
                var postdata = "action=myvformbrevo&param=save_vform&email="+getemail+"&"+nonce;
                jQuery.post(ajax_object,postdata,function(response){
                    $('.outerpopupvf').hide();
                    alert('Thank you for your submission.')
                });
            } else {
                alert('Invalid Email Please try again.')
            }
            });
            
        });
    });
</script>