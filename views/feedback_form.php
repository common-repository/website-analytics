<?php
?>
<div id="wpns_feedback_modal" class="mo_modal" style="width:90%; margin-left:12%; margin-top:5%; text-align:center; margin-left">

        <div class="mo_wpns_modal-content" style="width:50%;">
            <h3 style="margin: 2%; text-align:center;"><b>Your feedback</b><span class="mo_wpns_close" style="cursor: pointer">&times;</span>
            </h3>
			<hr style="width:75%;">
			
            <form name="f" method="post" action="" id="mo_wpns_feedback">

               <input type="hidden" name="option" value="mo_wpns_feedback"/>
                <input type="hidden" name="mo_site_nonce" value="<?php echo esc_html(wp_create_nonce('mo-site-feedback-nonce')); ?>"/>

                <div>
                    <p style="margin:2%">
					<h4 style="margin: 2%; text-align:center;">Please help us to improve our plugin by giving your opinion.<br></h4>
					
					<div id="smi_rate" style="text-align:center">
					<input type="radio" name="rate" id="angry" value="1"/>
						<label for="angry"><img class="sm" src="<?php echo esc_url($imagepath).'angry.png'; ?>" />
						</label>
						
					<input type="radio" name="rate" id="sad" value="2"/>
						<label for="sad"><img class="sm" src="<?php echo esc_url($imagepath).'sad.png'; ?>" />
						</label>
					
					
					<input type="radio" name="rate" id="neutral" value="3"/>
						<label for="neutral"><img class="sm" src="<?php echo esc_url($imagepath).'normal1.png'; ?>" />
						</label>
						
					<input type="radio" name="rate" id="smile" value="4"/>
						<label for="smile">
						<img class="sm" src="<?php echo esc_url($imagepath).'smile.png'; ?>" />
						</label>
						
					<input type="radio" name="rate" id="happy" value="5" checked/>
						<label for="happy"><img class="sm" src="<?php echo esc_url($imagepath).'happy.png'; ?>" />
						</label>
						
					<div id="outer" style="visibility:visible"><span id="result">Thank you for appreciating our work</span></div>
				</div><br>
					<hr style="width:75%;">
					<div style="text-align:center;">		
						<div style="display:inline-block; width:60%;">
						<input type="email" id="query_mail" name="query_mail" style="text-align:center; border:0px solid black; border-style:solid; background:#f0f3f7; width:20vw;border-radius: 6px;"
                              placeholder="your email address" required value="<?php echo esc_html($email); ?>" readonly="readonly"/>
						<input type="radio" name="edit" id="edit" onclick="editName()" value=""/>	
					    </div>
						<br><br>
						<textarea id="wpns_query_feedback" name="wpns_query_feedback" rows="4" style="width: 60%"
                              placeholder="Tell us what happened!"></textarea>
						<br><br>
						  <input type="checkbox" name="get_reply" value="reply" checked>miniOrange representative will reach out to you at the email-address entered above.</input>
					</div>
					<br>    
                    <div class="mo-modal-footer" style="text-align: center;margin-bottom: 2%">
                        <input type="submit" name="miniorange_feedback_submit"
                               class="mo_wpns_button mo_wpns_button1" value="Send"/>
						<span width="30%">&nbsp;&nbsp;</span>
                        <input type="button" name="miniorange_skip_feedback"
                               class="mo_wpns_button mo_wpns_button1" value="Skip" onclick="document.getElementById('mo_wpns_feedback_form_close').submit();"/>
                    </div>
        </div>
				<script>							
						const INPUTS = document.querySelectorAll('#smi_rate input');
						INPUTS.forEach(el => el.addEventListener('click', (e) => updateValue(e)));
						
						function editName(){
							document.querySelector('#query_mail').removeAttribute('readonly');
							document.querySelector('#query_mail').focus();
							return false;
						}
						function updateValue(e) {
							document.querySelector('#outer').style.visibility="visible";
							var result = 'Thank you for appreciating our work';
							switch(e.target.value){
								case '1':	result = 'Not happy with our plugin ? Let us know what went wrong';
											break;
								case '2':	result = 'Found any issues? Let us know and we\'ll fix it ASAP';
											break;
								case '3':	result = 'Let us know if you need any help';
											break;
								case '4':	result = 'We\'re glad that you are happy with our plugin';
											break;
								case '5':	result = 'Thank you for appreciating our work';
											break;
							}
							document.querySelector('#result').innerHTML = result;
						}
				</script>
				<style>
					.editable{
						text-align:center;
						width:1em;
						height:1em;
					}
					.sm {
						text-align:center;
						width: 2vw;
						height: 2vw;
						padding: 1vw;
					}

					input[type=radio] {
						display: none;
					}

					.sm:hover {
						opacity:0.6;
						cursor: pointer;
					}

					.sm:active {
					  	opacity:0.4;
					  	cursor: pointer;
					}

					input[type=radio]:checked + label > .sm {
					  	border: 2px solid #21ecdc;
					}
				</style>
            </form>
            <form name="f" method="post" action="" id="mo_wpns_feedback_form_close">
                <input type="hidden" name="option" value="mo_site_skip_feedback"/>
            <input type="hidden" name="mo_site_skip_nonce" value="<?php echo esc_html(wp_create_nonce('mo-site-skip-nonce')); ?>"/>

            </form>

        </div>

</div>

    <script>
  		

         jQuery('a[aria-label="Deactivate Website Analytics"]').click(function () {

            var mo_modal = document.getElementById('wpns_feedback_modal');

            var span = document.getElementsByClassName("mo_wpns_close")[0];

            mo_modal.style.display = "block";
			document.querySelector("#wpns_query_feedback").focus();
            span.onclick = function () {
                mo_modal.style.display = "none";
            }

            window.onclick = function (event) {
                if (event.target == mo_modal) {
                    mo_modal.style.display = "none";
                }
            }
            return false;

        });
    </script>