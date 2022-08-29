<? include_once("link.php");
$token=$_COOKIE['cookieToken']; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="css/footer.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script> 
        
</head>
<a href="#top" class="button-top">
    <i class="bi bi-arrow-up top"></i>
</a>
<script>
    let btn = document.querySelector('.button-top')

    function magic() {
    if (window.pageYOffset > 20) {
        btn.style.opacity = '1'
    } else { btn.style.opacity = '0' }
    }

    btn.onclick = function () {
        window.scrollTo(0,0)
    }

    window.onscroll = magic
</script>
<section class="footer">
    <div class="container ">
        <footer class="stiky-bottom">
            <div class="row">
                <div class="col-md-4">
                    <h4>О компании</h4>
                    <ul class="list-unstyled">
                        <li>Мы в сети</li>
                        <div class="footer-icons">
                            <a href="https://twitter.com/NastyaChinyaeva" class="link-footer"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.youtube.com/channel/UC8MCHmv9kPDtqd3yTIZXZqw" class="link-footer"><i class="fab fa-youtube"></i></a>
                            <a href="https://github.com/teasa7" class="link-footer"><i class="fab fa-github"></i></a>
                        </div>
                </div>

                <div class="col-md-4">
                    <h4>Контакты</h4>
                    <ul class="list-unstyled">
                        <li><a href="tel:+79605196239" class="link-footer">+7(000)000-00-00</a></li>
                        <li><a href="tel:+79615206340" class="link-footer">+7(965)534-92-64</a></li>
                        <li><a href="mailto:phoneset@gmail.com" target="_blank" rel="noopener noreferrer" class="link-footer">phoneset@gmail.com</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h4>Покупателям</h4>
                    <ul class="list-unstyled">
                        <li><a href="buyers.php#delivery" class="link-footer">О доставке</a></li>
                        <li><a href="buyers.php#registration" class="link-footer">Как оформить заказ</a></li>
                        <? if(!empty($token)) { ?>
                            <li><a href="my-orders.php" class="link-footer">Статус заказа</a></li>
                        <? } 
                        else { 
                            $error = 1; ?>
                            <li><a href="autorization.php?error=1" class="link-footer">Статус заказа</a></li>
                        <? }?>
                        <li><a href="buyers.php#payment" class="link-footer">Способы оплаты</a></li>
                    </ul>
                </div>    
            </div>
            
        </footer>
    </div>
</section>


</html>