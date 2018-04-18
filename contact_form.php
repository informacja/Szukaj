<div class=" sidebar pr-2" >
    <a class="hint--left" aria-label="Napisz do nas" data-toggle="modal"  data-target="#modalContactForm"> <i class="fa fa-envelope-o fa-2x text-light"> </i></a>
</div>
<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalContactForm">-->
<!--    Launch demo modal-->
<!--</button>-->
<!--<a href="" class="btn btn-default btn-rounded mb-4 waves-effect waves-light" data-toggle="modal" data-target="#modalContactForm">Launch Modal Contact Form</a>-->

<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--Modal: Contact form-->
    <div class="modal-dialog cascading-modal" role="document">

        <!--Content-->
        <div class="modal-content">
        <form action="?send_mail" method="post">
            <!--Header-->
            <div class="modal-header primary-color white-text">
                <h4 class="title">
                    <i class="fa fa-pencil"></i>Napisz do nas</h4>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body">

                <!-- Material input subject -->
                <div class="md-form form-sm">
                    <i class="fa fa-tag prefix"></i>
                    <input type="text" id="materialFormSubjectModalEx1" class="form-control form-control-sm"
                           placeholder="Wiadomość od gościa Biblioteki ZST" name="title">
                    <label for="materialFormSubjectModalEx1">Temat</label>
                </div>

                <div class="md-form">
                    <i class="fa fa-pencil prefix"></i>
                    <textarea id="textarea-char-counter" class="form-control md-textarea" length="120" required rows="3" name="message"></textarea>
                    <label for="textarea-char-counter">Twoja sugestia</label>
                </div>
                <!-- Material input name -->
<!--                <div class="md-form form-sm">-->
<!--                    <i class="fa fa-envelope prefix"></i>-->
<!--                    <input type="text" id="materialFormNameModalEx1" class="form-control form-control-sm">-->
<!--                    <label for="materialFormNameModalEx1">Your name</label>-->
<!--                </div>-->

                <!-- Material input email -->
                <div class="md-form form-sm">
                    <i class="fa fa-lock prefix"></i>
                    <input type="email" id="materialFormEmailModalEx1" class="form-control form-control-sm" name="mail">
                    <label for="materialFormEmailModalEx1">Email (podaj jeśli oczekujesz odpowiedzi)</label>
                </div>


                <!-- Material textarea message -->
<!--                <div class="md-form form-sm">-->
<!--                    <i class="fa fa-pencil prefix"></i>-->
<!--                    <textarea type="text" id="materialFormMessageModalEx1" class="md-textarea form-control"></textarea>-->
<!--                    <label for="materialFormMessageModalEx1">Your message</label>-->
<!--                </div>-->

                <div class="text-center mt-4 mb-2">
                    <button class="btn btn-primary" type="submit">Wyślij
                        <i class="fa fa-send ml-2"></i>
                    </button>
                </div>

            </div>
        </form>
        </div>
        <!--/.Content-->
    </div>
    <!--/Modal: Contact form-->
</div>

