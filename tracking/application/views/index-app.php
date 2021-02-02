<html>
    <head>
        <title>Tracking Order</title>
        <?php $this->load->view('css-js/css'); ?>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-secondary">
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <p class="text-white m-0 p-2">Tracking Orders</p>
            </div>
        </nav>

        <!-- <div class="col-md-12 col-12 mt-3">
            <form action="<?=site_url('config/active_tracking');?>" method="post">
                <input type="hidden" name="url_shopify" value="<?=$shopna->url_shopify;?>">
                <button class="btn btn-secondary" type="submit">Activate Apps</button>
            </form>
        </div> -->

        <div class="col-md-12 col-12 mt-3">
        	<div class="shopify-warning px-4 py-3">
                <p class="m-0">
                    <span class="warning-icon">
                        <svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><path d="M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm-1-8h2V6H9v4zm0 4h2v-2H9v2z" fill-rule="evenodd"></path></svg>
                    </span>
                    Track Orders app only accesses the last 60 days of orders.
                </p>
            </div>
        </div>

        <div class="row pt-3 m-0">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                        	<p>
                        		Your track order form will <b>not appear</b> before the application is <b>activated</b>, Click the "Activate Apps" button to activate the application.
                        	</p>
                            <h5 class="font-weight-bold mb-4">
                                Follow the steps below :
                            </h5>
                            <ol class="pl-3">
                                <li>

                                    Copy this code:

                                    <?php

                                    $data = "<div id='bdd-track-order'></div>";
                                    echo "<pre style='background-color: #f5f5f5; border: 1px solid #000; border-radius: 3px; padding: 5px 10px;width : fit-content;'>".htmlspecialchars($data, ENT_QUOTES)."</pre>";?>
                                </li>

                                <li>

                                    Go to <strong>Pages menu</strong> and then Add Page<br>

                                </li>

                                <li>

                                    Input the code 
                                    <?php
                                    $data = "<div id='bdd-track-order'></div>";
                                    echo "<pre style='background-color: #f5f5f5; border: 1px solid #000; border-radius: 3px; padding: 5px 10px; width : fit-content;'>".htmlspecialchars($data, ENT_QUOTES)."</pre>";?>

                                    in HTML Editor <br>

                                    <img src="<?php echo base_url() ?>assets/img/track order 2.PNG" class="img-fluid responsive-mobile-image" style="max-width: 50%;">

                                </li>
                                <li>
                                    Save the page
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom bg-secondary">
            <div class="container p-4" id="contact">
                <div class="contact text-white text-center">
                    <b>Need help? Don't hestitate to <a data-toggle="modal" data-target="#contact-footer" class="text-danger modalna">Contact Us</a>
                    </b>
                </div>
                <div class="modal fade" style="color: #000 !important; text-align: left !important;" id="contact-footer" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header no-bd">
                                <h3 class="modal-title">Contact</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <form action="<?=site_url('config/send_contact_mail');?>" method="post" id="contact-mail">
                            <div class="modal-body">
                                <input type="hidden" name="url_shopify" value="<?=$shopna->url_shopify;?>">
                                <input type="hidden" name="app_idna" value="<?=$shopna->id_merchant;?>">
                                <div class="form-group">
                                    <label class="control-label">Email (We will reply your messages to this email)</label>
                                    <input type="text" name="email_merchant" class="form-control" value="<?=$shopna->email_merchant;?>" placeholder="Your email">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Your name">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Subject</label>
                                    <input type="text" name="subjectna" class="form-control" placeholder="Your subject message">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea class="form-control" name="messagesna"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                    
                                    <button type="submit" class="btn btn-secondary btn-sm">Send Request</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('css-js/js'); ?>
    </body>
</html>