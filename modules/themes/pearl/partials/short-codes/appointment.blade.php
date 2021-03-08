<!-- Appointment Section -->
<section class="appointment-section">
    <h2>الحجز أونلاين</h2>
    <p>
        بمكنك الان الحجز اونلاين عن طريق ملىء الاستمارة بالاسفل وسيتم التواصل معك فى الحال
    </p>
    <div class="auto-container">
        <div class="outer-box">
            <div class="contact-form-two wow fadeInUp">
                <form method="post" id="contact-form">
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="text" name="username" placeholder="الاسم" required>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="tel" name="phone" placeholder="الهاتف" required>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="email" name="email" placeholder="البريد الالكترونى" required>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <select name="departments" id="departments" onchange="appointment();" required>
                                <option value="default" selected disabled>اختر القسم</option>
                                <option value="Cardiology">Cardiology</option>
                                <option value="Neurology">Neurology</option>
                                <option value="Urology">Urology</option>
                                <option value="Gynecological">Gynecological</option>
                                <option value="Pediatrical">Pediatrical</option>
                                <option value="Laboratory">Laboratory</option>
                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                            <input type="date" name="date" placeholder="dd-mm-yyyy" required="">
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <textarea name="message" placeholder="أضف رسالة" required=""></textarea>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <button class="btn btn-style" type="submit" name="submit-form"><span class="btn-title">إرسال </span></button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Appointment -->
