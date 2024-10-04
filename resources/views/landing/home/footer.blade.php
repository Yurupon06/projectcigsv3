<style>
    /* Footer Styles */
.footer {
    background-color: #fff;
    padding: 30px 0;
    color: #333;
}

.footer h5 {
    font-size: 18px;
    margin-bottom: 20px;
}

.footer p {
    font-size: 14px;
}

.footer ul {
    list-style: none;
    padding: 0;
}

.footer ul li {
    margin-bottom: 10px;
}

.footer .social-media {
    display: flex;
    gap: 10px;
}

.footer .social-media a {
    color: #333;
    font-size: 20px;
    text-decoration: none;
}
.about_us_text_color {
    color: {{ isset($landingSetting->about_us_text_color) ? $landingSetting->about_us_text_color: '#000' }};
}

</style>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>About Us</h5>
                <p class="about_us_text_color">{{ isset($landingSetting->about_us_text) ? $landingSetting->about_us_text : 'We are committed to providing the best fitness experience. Our gym is equipped with state-of-the-art equipment and staffed by highly trained professionals.' }}</p>
            </div>
            <div class="col-md-4">
                <h5>Contact Us</h5>
                <ul>
                    <li><i class="fa fa-map-marker"></i>
                    {{ $setting->app_address ?? '123 Faybal Gym, BITC Building 3rd Floor' }}</li>
                    <li><i class="fa fa-phone"></i>
                    {{ isset($landingSetting->phone_number) ? $landingSetting->phone_number :'123-456-7890' }}</li>
                    <li><i class="fa fa-envelope"></i>
                    {{ isset($landingSetting->email) ? $landingSetting->email : 'faybal@gym.com' }}</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Follow Us</h5>
                <ul class="social-media">
                    <li><a href="#" class="fa fa-facebook"></a>
                    {{ isset($landingSetting->facebook) ? $landingSetting->facebook : 'faybalgym' }}</li>
                    <li><a href="#" class="fa fa-twitter"></a>
                    {{ isset($landingSetting->twitter) ? $landingSetting->twitter : 'faybalgym' }}</li>
                    <li><a href="#" class="fa fa-instagram"></a>
                    {{ isset($landingSetting->instagram) ? $landingSetting->instagram : 'faybalgym' }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center mt-3">
        <p>&copy; 2024 Faybal Gym. All rights reserved.</p>
    </div>
</footer>
