<?
	ob_start();
	session_start();
	require_once('include/utilities/class.utilities.inc');
	require_once('include/utilities/class.timer.inc');
	require_once('include/utilities/class.browser.inc');
	require_once('include/login/controller/class.logincontroller.inc');
	
	$_utilities = new Utilities;
	$_timer = new Timer;
	$_browser = new Browser;
	$_logincontroller = new LoginController;
	
	$_utilities->CacheControl("Mon, 26 Jul 2030 05:00:00 GMT");
	$_timer->start_time();
	
	$_logincontroller->IntiateDatabase("localhost","itrixpv1_users","itrixceg","itrixpv1_users","registeredusers");
	$_logincontroller->DBLogin();
	
	$section = isset($_GET['section']) ? $_GET['section'] : '';
	$format = isset($_GET['format']) ? $_GET['format'] : '';
	
	$content = array();
	$authorisation = $_SESSION['User'];
	$sessiondata = $_SESSION['User']['email'];
	$userdata = array();
	$logoutbutton = '';
	$workshop_registration = array();
	$workshop_registration['bigdata'] = '';
	$workshop_registration['win8appdev'] = '';
	$workshop_registration['cyberforensics'] = '';
	
	$boxes_registration = array();
	$boxes_registration['bigdata'] = '';
	$boxes_registration['win8appdev'] = '';
	$boxes_registration['cyberforensics'] = '';
	
	
	if(!isset($authorisation) && empty($authorisation))
	{
		$userdata['name'] = "Guest";
		$workshop_registration['bigdata'] = '
												<p class="paragraph1">
													<button class="button1 logout" data-uri="http://bigdata-itrix.doattend.com">
														<img src="images/payment.png" width="32" height="32" style="display: inline-block; vertical-align: middle; "/>&nbsp; Pay Online. (Last Date: 28th Feb)
													</button>
												</p>
												<p class="paragraph1">
													On Spot Registration is available
												</p>
												<!--p class="paragraph1">
													<b>Mrs.Bama</b><br>
													<b>ISTA Treasurer</b><br>
													<b>Department of Information Science and Technology</b><br>
													<b>College of Engineering, Guindy</b><br>
													<b>Anna University, Chennai - 600 025</b><br>
												</p>
												<p class="paragraph1">
													Kindly write these in the backside of your DD - <b>Name, Contact Number, Email Address, Name of the Workshop</b>
												</p>
												<button class="register activatemodal" name="modalwindow">
													Login/Register
												</button-->
											';
		$workshop_registration['win8appdev'] = '
													<p class="paragraph1">
														<button class="button1 logout" data-uri="http://win8-itrix.doattend.com">
															<img src="images/payment.png" width="32" height="32" style="display: inline-block; vertical-align: middle; "/>&nbsp; Pay Online. (Last Date: 28th Feb)
														</button>
													</p>
													<p class="paragraph1">
														On Spot Registration is available
													</p>
													<!--p class="paragraph1">
														<b>Mrs.Bama</b><br>
														<b>ISTA Treasurer</b><br>
														<b>Department of Information Science and Technology</b><br>
														<b>College of Engineering, Guindy</b><br>
														<b>Anna University, Chennai - 600 025</b><br>
													</p>
													<p class="paragraph1">
														Kindly write these in the backside of your DD - <b>Name, Contact Number, Email Address, Name of the Workshop</b>
													</p>
													<button class="register activatemodal" name="modalwindow">
														Login/Register
													</button-->
												';
		$workshop_registration['cyberforensics'] = '
														<p class="paragraph1">
															<button class="button1 logout" data-uri="http://cyberforensics-itrix.doattend.com">
																<img src="images/payment.png" width="32" height="32" style="display: inline-block; vertical-align: middle; "/>&nbsp; Pay Online. (Last Date: 28th Feb)
															</button>
														</p>
														<p class="paragraph1">
															On Spot Registration is available
														</p>
														<!--p class="paragraph1">
															<b>Mrs.Bama</b><br>
															<b>ISTA Treasurer</b><br>
															<b>Department of Information Science and Technology</b><br>
															<b>College of Engineering, Guindy</b><br>
															<b>Anna University, Chennai - 600 025</b><br>
														</p>
														<p class="paragraph1">
															Kindly write these in the backside of your DD - <b>Name, Contact Number, Email Address, Name of the Workshop</b>
														</p>
														<button class="register activatemodal" name="modalwindow">
															Login/Register
														</button-->
													';
	}
	else
	{
		$userdata['name'] = $_logincontroller->GetUserData($sessiondata,'name');
		$userdata['email'] = $_logincontroller->GetUserData($sessiondata,'email');
		$userdata['phonenumber'] = $_logincontroller->GetUserData($sessiondata,'phonenumber');
		$userdata['organisationname'] = $_logincontroller->GetUserData($sessiondata,'organisationname');
		$userdata['accomdation'] = $_logincontroller->GetUserData($sessiondata,'accomdation');
		
		if($userdata['accomdation'] == "yes")
		{
			$yeschecked = "checked";
			$nochecked = "";
		}
		else
		{
			$yeschecked = "";
			$nochecked = "checked";
		}
		
		$logoutbutton = '
							<button class="button1 logout" data-uri="'.$_SESSION['logout'].'">
								Logout
							</button>
						';
						
		if($_logincontroller->CheckIfProfileComplete($userdata))
		{
		$workshop_registration['bigdata'] = '
												<p class="paragraph1">
													<button class="button1 logout" data-uri="http://bigdata-itrix.doattend.com">
														<img src="images/payment.png" width="32" height="32" style="display: inline-block; vertical-align: middle; "/>&nbsp; Pay Online. (Last Date: 28th Feb)
													</button>
													<center>(or)</center>
												</p>												
												<!--div id="bigdataformholder">
													<form action="javascript:void(0)" class="workshopregistrationform" name="bigdata" method="POST">
														<input type="text" placeholder="Bank" name="bank" value="" required title="Bank"/>
														<input type="text" placeholder="Branch" name="branch" value="" required title="Branch"/>
														<input type="text" placeholder="DD Number" name="ddnumber" value="" required title="DD Number"/>
														<input type="text" placeholder="Amount" name="amount" value="" required title="Amount"/>
														<input type="submit" name="submit" value="Submit"/>
													</form>
												</div-->
												<p class="paragraph1">
													On Spot Registration is available
												</p>
												<!--p class="paragraph1">
													<b>Mrs.Bama</b><br>
													<b>ISTA Treasurer</b><br>
													<b>Department of Information Science and Technology</b><br>
													<b>College of Engineering, Guindy</b><br>
													<b>Anna University, Chennai - 600 025</b><br>
												</p>
												<p class="paragraph1">
													Kindly write these in the backside of your DD - <b>Name, Contact Number, Email Address, Name of the Workshop</b>
												</p-->
											';
		
		$workshop_registration['win8appdev'] = '
													<p class="paragraph1">
														<button class="button1 logout" data-uri="http://win8-itrix.doattend.com">
															<img src="images/payment.png" width="32" height="32" style="display: inline-block; vertical-align: middle; "/>&nbsp; Pay Online. (Last Date: 28th Feb)
														</button>
														<center>(or)</center>
													</p>	
													<!--div id="win8appdevformholder">
														<form action="javascript:void(0)" class="workshopregistrationform" name="win8appdev" method="POST">
															<input type="text" placeholder="Bank" name="bank" value="" required title="Bank"/>
															<input type="text" placeholder="Branch" name="branch" value="" required title="Branch"/>
															<input type="text" placeholder="DD Number" name="ddnumber" value="" required title="DD Number"/>
															<input type="text" placeholder="Amount" name="amount" value="" required title="Amount"/>
															<input type="submit" name="submit" value="Submit"/>
														</form>
													</div-->
													<p class="paragraph1">
														On Spot Registration is available
													</p>
													<!--p class="paragraph1">
														<b>Mrs.Bama</b><br>
														<b>ISTA Treasurer</b><br>
														<b>Department of Information Science and Technology</b><br>
														<b>College of Engineering, Guindy</b><br>
														<b>Anna University, Chennai - 600 025</b><br>
													</p>
													<p class="paragraph1">
														Kindly write these in the backside of your DD - <b>Name, Contact Number, Email Address, Name of the Workshop</b>
													</p-->
												';
												
		
		$workshop_registration['cyberforensics'] = '
														<p class="paragraph1">
															<button class="button1 logout" data-uri="http://cyberforensics-itrix.doattend.com">
																<img src="images/payment.png" width="32" height="32" style="display: inline-block; vertical-align: middle; "/>&nbsp; Pay Online. (Last Date: 28th Feb)
															</button>
															<center>(or)</center>
														</p>	
														<!--div id="cyberforensicsformholder">
															<form action="javascript:void(0)" class="workshopregistrationform" name="cyberforensics" method="POST">
																<input type="text" placeholder="Bank" name="bank" value="" required title="Bank"/>
																<input type="text" placeholder="Branch" name="branch" value="" required title="Branch"/>
																<input type="text" placeholder="DD Number" name="ddnumber" value="" required title="DD Number"/>
																<input type="text" placeholder="Amount" name="amount" value="" required title="Amount"/>
																<input type="submit" name="submit" value="Submit"/>
															</form>
														</div-->
														<p class="paragraph1">
															On Spot Registration is available
														</p>
														<!--p class="paragraph1">
															<b>Mrs.Bama</b><br>
															<b>ISTA Treasurer</b><br>
															<b>Department of Information Science and Technology</b><br>
															<b>College of Engineering, Guindy</b><br>
															<b>Anna University, Chennai - 600 025</b><br>
														</p>
														<p class="paragraph1">
															Kindly write these in the backside of your DD - <b>Name, Contact Number, Email Address, Name of the Workshop</b>
														</p-->
													';
		}
		else
		{
			$workshop_registration['cyberforensics'] = '
															<p class="paragraph1">
																Kindly Complete your profile to perform registration.
															</p>
														';
											
			$workshop_registration['bigdata'] = '
													<p class="paragraph1">
														Kindly Complete your profile to perform registration.
													</p>
												';
												
			$workshop_registration['win8appdev'] = '
														<p class="paragraph1">
															Kindly Complete your profile to perform registration.
														</p>
													';
		}
		
		if($_logincontroller->CheckWorkshopRegistration($userdata['email'],'w_win8appdev'))
		{
			$boxes_registration['win8appdev'] = 	'
													<li class="first-child">
														<div class="curve-down">
															<a href="#!/workshops/windows8appdevelopment">
																<img src="images/boxes/win8.png" alt="" width="237" height="185" />
															</a>
														</div>
													</li>
												';
												
			$workshop_registration['win8appdev'] = '
														<p class="paragraph1">
															You have already registered for <b>WINDOWS 8 APP DEVELOPMENT</b> workshop. Kindly follow the below instructions.
														</p>
														<p class="paragraph1">
															Demand Draft in favour of <b>Information Science and Technology Association</b><br>
															DD to be sent to:
														</p>
														<p class="paragraph1">
															<b>Mrs.Bama</b><br>
															<b>ISTA Treasurer</b><br>
															<b>Department of Information Science and Technology</b><br>
															<b>College of Engineering, Guindy</b><br>
															<b>Anna University, Chennai - 600 025</b><br>
														</p>
														<p class="paragraph1">
															Kindly write these in the backside of your DD - <b>Name, Contact Number, Email Address, Name of the Workshop</b>
														</p>
													';
		}
		
		if($_logincontroller->CheckWorkshopRegistration($userdata['email'],'w_cyberforensics'))
		{												
			$boxes_registration['cyberforensics'] = 	'
													<li class="second-child">
														<div class="curve-down">
															<a href="#!/workshops/cyberforensics">
																<img src="images/boxes/cbf.png" alt="" width="237" height="185" />
															</a>
														</div>
													</li>
												';
												
			$workshop_registration['cyberforensics'] = '
															<p class="paragraph1">
																You have already registered for <b>CYBER FORENSICS</b> workshop. Kindly follow the below instructions.
															</p>
															<p class="paragraph1">
																Demand Draft in favour of <b>Information Science and Technology Association</b><br>
																DD to be sent to:
															</p>
															<p class="paragraph1">
																<b>Mrs.Bama</b><br>
																<b>ISTA Treasurer</b><br>
																<b>Department of Information Science and Technology</b><br>
																<b>College of Engineering, Guindy</b><br>
																<b>Anna University, Chennai - 600 025</b><br>
															</p>
															<p class="paragraph1">
																Kindly write these in the backside of your DD - <b>Name, Contact Number, Email Address, Name of the Workshop</b>
															</p>
														';
		}
		
		if($_logincontroller->CheckWorkshopRegistration($userdata['email'],'w_bigdata'))
		{												
			$boxes_registration['bigdata'] = 	'
														<li class="third-child">
															<div class="curve-down">
																<a href="#!/workshops/bigdata">
																	<img src="images/boxes/bdata.png" alt="" width="237" height="185" />
																</a>
															</div>
														</li>
													';
													
			$workshop_registration['bigdata'] = '
													<p class="paragraph1">
														You have already registered for <b>BIG DATA</b> workshop. Kindly follow the below instructions.
													</p>
													<p class="paragraph1">
														Demand Draft in favour of <b>Information Science and Technology Association</b><br>
														DD to be sent to:
													</p>
													<p class="paragraph1">
														<b>Mrs.Bama</b><br>
														<b>ISTA Treasurer</b><br>
														<b>Department of Information Science and Technology</b><br>
														<b>College of Engineering, Guindy</b><br>
														<b>Anna University, Chennai - 600 025</b><br>
													</p>
													<p class="paragraph1">
														Kindly write these in the backside of your DD - <b>Name, Contact Number, Email Address, Name of the Workshop</b>
													</p>
												';
		}
	}
	
	$menu_events = 	'
						<ul class="accordion">
							<li>Onsite Events</li>
							<ul>
								<li><a href="#!/events/onsite/datastructs">Data Structs</a></li>
								<li><a href="#!/events/onsite/raid">RAID</a></li>
								<li><a href="#!/events/onsite/theprotocol">The Protocol</a></li>
								<li><a href="#!/events/onsite/enigma">Enigma</a></li>
								<li><a href="#!/events/onsite/scriptit">Script IT</a></li>
								<li><a href="#!/events/onsite/o(1)">O(1)</a></li>
								<li><a href="#!/events/onsite/fixit">Fix IT</a></li>
								<li><a href="#!/events/onsite/itrixquiz">Itrix Quiz</a></li>
								<li><a href="#!/events/onsite/webprodigy">Web Prodigy</a></li>
								<li><a href="#!/events/onsite/megaevent">Mega Event</a></li>
							</ul>
							<li>Online Events</li>
							<ul>
								<li><a href="#!/events/online/codeconundrum">Code Conundrum</a></li>
								<li><a href="#!/events/online/chamberofsecrets">Chamber of Secrets</a></li>
								<li><a href="#!/events/online/clickit!">Click It!</a></li>
							</ul>
							<li class="link"><a href="#!/events/paperpresentation">Paper Presentation</a></li>
							<ul></ul>
							<li class="link"><a href="#!/events/gaminarena">Gamin Arena</a></li>
							<ul></ul>
						</ul>
					';
					
	$menu_workshops = 	'
							<ul class="accordion">
								<li>Workshop List</li>
								<ul>
									<li><a href="#!/workshops/bigdata">Big Data</a></li>
									<li><a href="#!/workshops/cyberforensics">Cyber Forensics</a></li>
									<li><a href="#!/workshops/windows8appdevelopment">Windows 8 App Development</a></li>
								</ul>
							</ul>
						';
	
	switch($section)
	{
		case 'home':
			sleep(2);
			if(!isset($authorisation) && empty($authorisation))
			{
				$content = array(
								'title' => 'Home | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<figure id="slideshow">
																<div>
																	<img src="images/slider/1.png"/>
																</div>
																<div>
																	<img src="images/slider/2.png"/>
																</div>
																<div>
																	<img src="images/slider/3.png"/>
																</div>
																<div>
																	<img src="images/slider/4.png"/>
																</div>
																<div>
																	<img src="images/slider/5.png"/>
																</div>
															</figure>
															<div class="updates">
																<span>Updates</span>
																<ul class="ticker">
																	<li>PAPER PRESENTATION: Shortlisted Papers have been published. Kindly Check.</li>
																	<li>The Doors of the Chamber of Secrets are OPEN</li>
																	<li>Internships for winners of O(1), FIX IT, Data Structs and Web Prodigy</li>
																	<li>IMPORTANT: Events Schedule is available in Events Tab</li>
																	<li>IMPORTANT: Last Date for submission of DD for workshop is over.</li>
																	<li>If you want accomodation please update it in your profile.</li>
																	<li>Onspot registrations are also available for the workshops !!!</li>
																</ul> 
															</div>
															<button class="register activatemodal" name="modalwindow">
																Login/Register
															</button>
															<button class="workshopregister" name="registerforworkshop" data-uri="#!/workshops">
																Register for Workshop
															</button>
														</article>
														<article class="levelholder">
															<div class="boxes">
																<ul>
																	<li class="first-child">
																		<div class="curve-down">
																			<a href="#!/workshops/windows8appdevelopment">
																				<img src="images/boxes/win8.png" alt="" width="237" height="185" />
																			</a>
																		</div>
																	</li>
																	<li class="second-child">
																		<div class="curve-down">
																			<a href="#!/workshops/cyberforensics">
																				<img src="images/boxes/cbf.png" alt="" width="237" height="185" />
																			</a>
																		</div>
																	</li>
																	<li class="third-child">
																		<div class="curve-down">
																			<a href="#!/workshops/bigdata">
																				<img src="images/boxes/bdata.png" alt="" width="237" height="185" />
																			</a>
																		</div>
																	</li>
																	<li class="last-child">
																		<div class="curve-down">
																			<a href="#!/events/online/codeconundrum">
																				<img src="images/boxes/opc.png" alt="" width="237" height="185" />
																			</a>
																		</div>
																	</li>
																</ul>										
															</div>
														</article>
													'
								);
			}
			else
			{
				sleep(2);
				$content = array(
									'title' => 'Profile | ITRIX 2013',
									'.pageholder' => 	'
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">PROFILE</h1>
																</header>
																<form action="javascript:void(0)" action="POST" class="profileform">
																	<div class="formrow">
																		<label for="name">Name</label>
																		<input type="text" placeholder="Name" name="name" value="'.$userdata['name'].'" title="Full Name as in Certification"/>
																	</div>
																	<div class="formrow">
																		<label for="email">Email</label>
																		<input type="text" placeholder="Email" name="email" value="'.$userdata['email'].'" disabled title="Email Address cannot be edited."/>
																	</div>
																	<div class="formrow">
																		<label for="phonenumber">Contact Number</label>
																		<input type="text" placeholder="Landline/Mobile Number" name="phonenumber" value="'.$userdata['phonenumber'].'" title="Landline/Mobile Number"/>
																	</div>
																	<div class="formrow">
																		<label for="organisationname">College Name</label>
																		<input type="text" placeholder="Organisation/Institution Name" name="organisationname" value="'.$userdata['organisationname'].'" title="Organisation/Institution/College/School Name"/>
																	</div>
																	<div class="formrow">
																		<label for="accomdation">Accomdation</label>
																		<section class="radioholder">
																			<input type="radio" name="accomdation[]" value="no" title="No" '.$nochecked.'/>No
																			<input type="radio" name="accomdation[]" value="yes" title="Yes" '.$yeschecked.'/>Yes
																		</section>
																	</div>
																	<div class="formrow">
																		<input type="submit" name="submit" value="Submit"/>
																	</div>
																	<div class="profilestatusholder">
																		<div class="profilesavestatus">Saved</div>
																	</div>
																</form>
															</section>
															<aside class="rightsidebarnavigation">
																'.$logoutbutton.'
															</aside>
														</article>
														<article class="levelholder">
															<p class="paragraph1">
																The list of workshops you have registered.
															</p>
														</article>
														<article class="levelholder">
															<div class="boxes">
																<ul>
																	'.$boxes_registration['win8appdev'].'
																	'.$boxes_registration['cyberforensics'].'
																	'.$boxes_registration['bigdata'].'
																</ul>
															</div>
														</article>
															
													'
								);	
			}
			break;
			
		case 'events':
			sleep(2);
			$content = array(
								'title' => 'Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">EVENTS</h1>
																</header>
																<p class="paragraph1">
																	<a href="pdf/schedule.pdf">Download Event Schedule Here</a>
																</p>
																<p class="paragraph1">
																	ITrix \'13 events is the crown jewel of the 2 day techfest hosted by the IST department .
																</p>
																<p class="paragraph1">
																	We have an assorted ensemble of events for honing every skill , talent , innovation , creativity and brain power present out there . It covers not only the technical aspects but also photography , mathpower , design and much more .
																</p>
																<p class="paragraph1">
																	Check in to challenge others and yourself!
																</p>
																<p class="paragraph1">
																	Pop up to experience exhilaration!
																</p>
																<p class="paragraph1">
																	Take a whiff of ITrix \'13 Events!!! It\'s now or never!!
																</p>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'events/paperpresentation':
			sleep(2);
			$content = array(
								'title' => 'Paper Presentation - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">PAPER PRESENTATION</h1>
																	<img src="images/cover/ppt.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Topics</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Judging Parameters</a></li>
																			<li><a href="javascript:void(0);" class="tab5">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab6">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				<a href="pdf/Shortlisted Students List.pdf" target="_blank">Click Here to check for Shortlisted Papers</a>
																			</p>
																			<p class="paragraph1">
																				Are you one among those who think technology is the root cause for all woes in the world?
																			</p>
																			<p class="paragraph1">
																				Do you always possess innovative ideas for all problems, be it trivial like a  drainage problem in the locality or critical like international terrorism? 
																			</p>
																			<p class="paragraph1">
																				Then this is the place for you !! Here awaits an opportunity to put forth your ideas in front of intellectuals from diverse fields. 
																			</p>
																			<p class="paragraph1">
																				Chalk out a composed abstract based on the topics given below and make your submission as per the rules . A few papers will be shortlisted for onsite presentation on the day of the event. Come and showcase your talent at one of the best platforms .
																			</p>
																			<!--p class="paragraph1">
																				1.&nbsp;<b>An Innovative Mobility Based Clustering Algorithm for MANET</b><br>
																				&nbsp;&nbsp;&nbsp;&nbsp;by S.Mathangi,R.Manoranjani,M.Vaishali<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Department of Information Technology,<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Thiyagarajar College of Engineering, Madurai.<br>																				
																			</p>
																			<p class="paragraph1">
																				2.&nbsp;<b>Cloud Based Real Time Virus Protection</b><br>
																				&nbsp;&nbsp;&nbsp;&nbsp;by T.Aravindhan,R.Bharani<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Computer Science and Engineering,<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;SSN Chennai.<br>	
																			</p>
																			<p class="paragraph1">
																				3.&nbsp;<b>Data Dredging for Streaming Data Nuggets Using XQUERIES.</b><br>
																				&nbsp;&nbsp;&nbsp;&nbsp;by R.Vaishanavi,A.T.Sumitha<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Computer Science and Engineering,<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Sri Sairam Engineering College, Chennai.<br>
																			</p>
																			<p class="paragraph1">
																				4.&nbsp;<b>A Hardware Keyboard for visually Impaired.</b><br>
																				&nbsp;&nbsp;&nbsp;&nbsp;by Sandhiya R,DhivayaLakshmi MK<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Information Technology,<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Jerusalem Engineering College, Chennai.<br>
																			</p>
																			<p class="paragraph1">
																				5.&nbsp;<b>Server side cache optimization to run computationally heavy applications using mobile cloud</b><br>
																				&nbsp;&nbsp;&nbsp;&nbsp;by Rohit Sethi, Naren Sai Rajasekaran, Harika Kandala<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Information Technology,<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;College of Engineering, Guindy.<br>
																			</p>
																			<p class="paragraph1">
																				6.&nbsp;<b>Rails an Insight</b><br>
																				&nbsp;&nbsp;&nbsp;&nbsp;by Rohit Sethi, Naren Sai Rajasekaran, Harika Kandala<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Information Technology,<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;College of Engineering, Guindy.<br>
																			</p>
																			<p class="paragraph1">
																				5.&nbsp;<b>Server side cache optimization to run computationally heavy applications using mobile cloud</b><br>
																				&nbsp;&nbsp;&nbsp;&nbsp;by Rohit Sethi, Naren Sai Rajasekaran, Harika Kandala<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;Information Technology,<br>
																				&nbsp;&nbsp;&nbsp;&nbsp;College of Engineering, Guindy.<br>
																			</p--!>
																		</div>
																		<div id="tab2" class="none">																	
																			<ul class="liststyle1">
																				<li>Cloud Computing</li>
																				<li>Artificial Intelligence</li>
																				<li>Network security</li>
																				<li>Big data analysis</li>
																				<li>Green computing</li>
																				<li>Recent Developments in the field of IT</li>
																				<li>Real time applications</li>
																			</ul>
																			<p class="paragraph1">
																				PS : Innovative papers from other topics are also welcome. 
																			</p>
																		</div>
																		<div id="tab3" class="none">
																			<p class="paragraph1">
																				<b>Round 1 (Abstract Submission):</b>
																			</p>
																			<ul class="liststyle1">
																				<li>Participants are required to submit their abstract.</li>
																				<li>Soft copy of your abstract should be submitted as WORD (.doc) or PDF (.pdf). No other submission will  be entertained.</li>
																				<li>Mail your abstract to <a href="mailto:ppt@itrix.in">ppt@itrix.in</a></li>
																				<li>Abstract font should be <b>Times New Roman</b> and size should be 12.</li>
																				<li><b>Two column format</b>(IEEE format) should be adopted.</li>
																				<li>Deadline for submission is <b><u>20/02/13</u></b>.</li>
																				<li>Participants shortlisted in first round will be intimated through mail.</li>
																				<li>Details of all the team members (Name, dept, college) should be sent along with the paper.</li>
																			</ul>
																			<p class="paragraph1">
																				<b>Round 2 (Presentation during ITRIX \'13):</b>
																			</p>
																			<ul class="liststyle1">
																				<li>Participants need to bring <b>1 soft copy</b> and <b>3 hard copies</b> of your paper.</li>
																				<li>Team members have to present their papers before our esteemed panel.</li>
																				<li>Each team will get <b>10 minutes</b> for presentation, followed by queries.</li>
																			</ul>
																		</div>
																		<div id="tab4" class="none">
																			<ul class="liststyle1">
																				<li>Creativity and effort.</li>
																				<li>Clarity and expression</li>
																				<li>Methodology</li>
																				<li>Finding and analysis</li>
																				<li>Conclusion</li>
																				<li>Application/Limitation</li>
																			</ul>
																			<p class="paragraph1">
																				NOTE: The decision of the judges shall be the final and binding.
																			</p>
																		</div>
																		<div id="tab5" class="none">
																			<ul class="liststyle1">
																				<li>Event is open to all students belonging to all streams.</li>
																				<li>Size of the team should be a <b>maximum of 3</b>. All team members are <b>not required</b> to be enrolled at the same institution.</li>
																				<li>Students should bring their <b>ID</b> card otherwise they will not be allowed to present on stage.</li>
																				<li>No student should be the author of more than one paper.</li>
																				<li>Results will be announced on the website and will be mailed to the team members.</li>
																				<li><b>Date, Time and Prize money will be intimated soon.</b></li>
																			</ul>
																		</div>
																		<div id="tab6" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Jagatheeshwaran</div>
																				<div class="spannumber">+91 9566302330</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Mallikarjun</div>
																				<div class="spannumber">+91 9791181018</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;		
			
		
		case 'events/gaminarena':
			sleep(2);
			$content = array(
								'title' => 'Gamin Arena - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">GAMIN ARENA</h1>
																</header>
																<section class="tabbedholder">
																	<img src="images/gaminarena.jpg" width="600" height="400"/>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;		
			
		case 'events/onsite/datastructs':
			sleep(2);
			$content = array(
								'title' => 'DataStructs - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">DATA STRUCTS</h1>
																	<img src="images/cover/datastructs.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				Want to appraise the knowledge you have on Data Structures?
																			</p>
																			<p class="paragraph1">
																				You think you need to meliorate the understanding you have on the subject? 
																			</p>
																			<p class="paragraph1">
																				Well, this the germane place for you to discover, explore and empower your cognition in efficient data management.
																			</p>
																			<p class="paragraph1">
																				<b>"It is better to have 100 functions operate on one data structure than 10 functions on 10 data structures."</b> - Alan J. Perlis
																			</p>
																			<p class="paragraph1">
																				<b>Prize:</b> Will be announced later.
																			</p>
																			<p class="paragraph1">
																				The winners of this event will get internship offer at Amazon.
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<ul class="liststyle1">
																				<li>The event consists of 2 Rounds. The first round is the prelims.</li>
																				<li>The question paper has 3 sections each with 10 questions.</li>
																				<li>Those who make it through the prelims will get to participate in the finals.</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>No negative marking.</li>
																				<li>Event Duration is 45 minutes.</li>
																				<li>The participants should register themselves before the event starts.</li>
																				<li>Any participant or team caught cheating will be immediately disqualified.</li>
																			</ul>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Ashok Sriram Pandian</div>
																				<div class="spannumber">+91 9790539447</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Rahul Aravind</div>
																				<div class="spannumber">+91 9042714156</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Aravind</div>
																				<div class="spannumber">+91 9698050596</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">datastruct@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
		
		case 'events/onsite/enigma':
			sleep(2);
			$content = array(
								'title' => 'Enigma - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">ENIGMA</h1>
																	<img src="images/cover/enigma.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				This event stands to showcase your inner quintessential "MATH GEEK".
																			</p>
																			<p class="paragraph1">
																				 The event "Enigma" identifies the people with inductive reasoning aptitude by testing the participants on their Problem tackling and solving skills. The ingenuity of the participant is tested here.
																			</p>
																			<p class="paragraph1">
																				The road to victory consists of simple mathematical puzzles, brain teasers and general aptitude.
																			</p>
																			<p class="paragraph1">
																				Come show off your math skills at ENIGMA!
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<p class="paragraph1">
																				The event is going to be conducted in 2 rounds:
																			</p>
																			<p class="paragraph1">
																				Prelims and finals consists of written tests
																			</p>
																																						
																			<ul class="liststyle1">
																				<li>Prelims - 30 questions (1 Hour)</li>
																				<li>Finals - 15 questions  (1 Hour)</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>Every participant must <b>register</b> at the <b>hospitality</b> desk before the event starts</li>
																				<li>Only team entry allowed (<b>2 per team</b>)</li>
																				<li>Prelims will be held to shortlist the number of teams. Short listed students from the first round are allowed to participate in the second round (Final Round).</li>
																				<li><b>No</b> external help / Usage of calculators / Internet search .</li>
																				<li>Participants found using any or all kinds of malpractice will be <b>eliminated</b> immediately.</li>
																				<li>Judgement is final and not applicable to further changes.</li>
																			</ul>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Jothy</div>
																				<div class="spannumber">+91 9566888928</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Madhumathi</div>
																				<div class="spannumber">+91 9884410092</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">enigma@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;		
			
		case 'events/onsite/fixit':
			sleep(2);
			$content = array(
								'title' => 'Fix IT - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">FIX IT</h1>
																	<img src="images/cover/fixit.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				The Event "Fix IT!" throws the spotlight on the participants\' ability to debug and test code. It aims at recognizing their hidden potential by testing their Technical skills. The participants of this contest are tested for both their perception and intuition in the areas of computer programming. It provides a beneficial platform for tomorrow\'s professionals to explore their debugging capabilities.
																			</p>
																			<p class="paragraph1">
																				<b>"It\'s hard enough to find an error in your code when you\'re looking for it; it\'s even harder when you\'ve assumed your code is error-free."</b> - Steve McConnel
																			</p>
																			<p class="paragraph1">
																				The winners of this event will get internship offer at EMO2.
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<p class="paragraph1">
																				A double round event 
																			</p>
																			<ul class="liststyle1">
																				<li>Knowledge of C, C++, Java is advantageous.</li>
																				<li>Prelims - 25 questions</li>
																				<li>Finals - 5 questions (will be held at SPOJ (Duration 1 hour))</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>A maximum of two members per team.</li>
																				<li>Every participant must <b>register</b> at the <b>hospitality</b> desk before the event starts</li>
																				<li>We will need your College ID card for this.</li>
																				<li>Any participant or team caught cheating will immediately be disqualified.</li>
																				<li>Only short listed students from the first round (Prelims) will be allowed to participate in the second round (Finals).</li>
																				<li>The judge\'s decision will be final.</li>
																				<li>Judgement is final and not applicable to further changes.</li>
																			</ul>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Nandhini Krishnan</div>
																				<div class="spannumber">+91 9500433713</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">fixit@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;	

		case 'events/onsite/itrixquiz':
			sleep(2);
			$content = array(
								'title' => 'ITRIX Quiz - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">ITRIX QUIZ</h1>
																	<img src="images/cover/quiz.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab3">FAQ</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				"Knowledge is Power" - Francis Bacon.
																			</p>
																			<p class="paragraph1">
																				If you are one of those people who are intrigued by the most random of facts, if you are someone who questions all that is around him, origins, etymologies, trivia, funda and whatnot, then the ITrix Gen Quiz awaits you. Can you beat the odds and rise to be a Quizzing superstar? 
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<ul class="liststyle1">
																				<li>Teams of 2 or 3.</li>
																				<li>Every participant must register at the hospitality desk before the event starts</li>
																				<li>We will need your College ID card for this</li>
																				<li>No lone wolves will be allowed to participate</li>
																				<li>There will be a preliminary round followed immediately by finals</li>
																				<li>The top 6 teams will make it to the finals.</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<dl class="faq">
																				<dt>Sir, I am new to Quizzes and Quizzing. What can I do to prepare?</dt>
																				<dd>
																					Read the papers. Watch the News on TV (if possible). Attend more quizzes. Have an Interest in knowing about random stuff ranging from Aardvark to Nietzsche and Otakuism to Zynga. (Note, nothing mentioned here will come but if you are really jobless, poi google panra.)
																				</dd>
																				<dt>Sir, Is there any sites/learning material?</dt>
																				<dd>
																					People asking such questions will be banned from participating. For the rest of you, if you want to know more about something that interests you I will refer you to www.wikipedia.com and www.google.com
																				</dd>
																				<dt>Sir, How much prize money will be given?</dt>
																				<dd>
																					First, you come to finals. 
																				</dd>
																				<dt>Sir, How many rounds will the Quiz be? How long will it be?</dt>
																				<dd>
																					See above.
																				</dd>
																			</dl>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Mohit Bagde</div>
																				<div class="spannumber">+91 9444938700</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Siddarth U</div>
																				<div class="spannumber">+91 9884945304</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;		
			
		case 'events/onsite/megaevent':
			sleep(2);
			$content = array(
								'title' => 'Mega Event - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">MEGA EVENT</h1>
																	<img src="images/cover/megaevent.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				Want to be crowned the  "Winner of Winners"?!!
																			</p>
																			<p class="paragraph1">
																				This is a "NOT to be missed" mega event of ITrix \'13 that is an amalgamation of  fun technical knickknacks , subtle brainteasers and bombarding ideas extending  over 3 different rounds. The questions can range from "ANYTHING AND EVERYTHING" that comes under the banner "Information Technology" !! 
																			</p>
																			<p class="paragraph1">
																				This is a calling to each and every particpant who emerges victorious at any one  of the below mentioned ITRIX \'13 events . 
																			</p>
																			<p class="paragraph1">
																				The acceptable Events include
																			</p>
																			<p class="paragraph1">
																				<b>ONLINE</b>
																			</p>
																			<ul class="liststyle1">
																				<li>Fix IT</li>
																				<li>Data Structs</li>
																				<li>Enigma</li>
																				<li>Itrix Quiz</li>
																				<li>Script IT</li>
																				<li>RAID</li>
																				<li>O(1)</li>
																				<li>Click IT</li>
																				<li>Web Prodigy</li>
																				<li>The Protocol</li>
																			</ul>
																			<p class="paragraph1">
																				So Guys Get Ready to battle it out and win the Coveted Title  and exciting cash awards!
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<ul class="liststyle1">
																				<li>There are 3 rounds each of different time duration</li>
																				<li>
																					Every round is an elimination round
																					<p class="paragraph1">
																						<b>ROUND 1</b> : A written preliminary round.
																					</p>
																					<p class="paragraph1">
																						<b>ROUND 2</b> : A problem will be given that needs innovative solutions.
																					</p>
																					<p class="paragraph1">
																						<b>ROUND 3</b> : Timed Rapid Fire.
																					</p>
																				</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>Only individual participation is allowed. This is not a team event.</li>
																				<li>Every participant must <b>register</b> at the <b>hospitality desk</b> before the event starts</li>
																				<li>We will need your <b>College ID</b> card for this</li>
																				<li>Only the <b>top 3 WINNERS</b> of other ITrix onsite events are allowed to participate.</li>
																				<li>Judge\'s decision is final.</li>
																				<li>Any proof of malpractice found will lead to immediate elimination of participant.</li>
																			</ul>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Nivethitha</div>
																				<div class="spannumber">+91 9884251104</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Sneha</div>
																				<div class="spannumber">+91 9791143778</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">megaevent@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;		
			
		case 'events/onsite/o(1)':
			sleep(2);
			$content = array(
								'title' => 'O(1) - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">O(1)<figure style="position: relative; display: inline; float: right; background-image:url(\'images/sponsors/current/events/indix.png\'); background-size: 118px 93px; width: 118px; height: 93px;"/></h1>
																	<img src="images/cover/o(1).png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				<b>"The best programmers are not marginally better than merely good ones.  They are an order-of-magnitude better, measured by whatever standard: conceptual creativity, speed, ingenuity of design, or problem-solving ability"</b> - Randall E. Stross
																			</p>
																			<p class="paragraph1">
																				Are you the typical \'geek\' passionate about coding??  Then welcome to Onsite Programming Contest of ITRIX 2013! We provide you a platform where the boundaries between possibility and impossibility blur. Come fight out one of the most challenging coding contest of the year!
																			</p>
																			<p class="paragraph1">
																				Don\'t worry if it doesn\'t work right.  If everything did, you\'d be out of a job. - Mosher\'s Law of Software Engineering
																			</p>
																			<p class="paragraph1">
																				The winners of this event will get internship offer at INDIX.
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<ul class="liststyle1">
																				<li>Each team can consist maximum of 2 members</li>
																				<li>No contestant can be a member of more than one team</li>
																				<li>Participants are not allowed to bring any additional material</li>
																				<li>Involvement in any kind of malpractice will be immediately disqualified</li>
																				<li>Organiser\'s decisions will be final and binding</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<p class="paragraph1">
																				<b>Prelims</b>
																			</p>
																			<ul class="liststyle1">
																				<li>The Prelims consist of questions from basic algorithms and a few questions on data structures.</li>
																				<li>All questions will be real time problems.</li>
																			</ul>
																			<p class="paragraph1">
																				<b>Finals</b>
																			</p>
																			<ul class="liststyle1">
																				<li>Finals will be a game development round.</li>
																				<li>This game will be a strategic one like chess. </li>
																				<li>An arena will be given and the contestants have to code a bot.</li>
																				<li>Two bots will be allowed to battle.</li>
																				<li>It will be a play-off, means the more the matches won by a player he will be crowned the winner of the contest.</li>
																			</ul>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Prakash D.</div>
																				<div class="spannumber">+91 9597726205</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Yuvaraja B.</div>
																				<div class="spannumber">+91 9789553811</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">o1@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'events/onsite/raid':
			sleep(2);
			$content = array(
								'title' => 'RAID - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">RAID</h1>
																	<img src="images/cover/raid.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				Every day is an irreversible Transaction. No rollbacks. No fall backs. Only Flashbacks.
																			</p>
																			<p class="paragraph1">
																				Imagine Life without Intelligence
																			</p>
																			<p class="paragraph1">
																				Imagine Computing without a Computer
																			</p>
																			<p class="paragraph1">
																				Imagine Social Networking without a Network
																			</p>
																			<p class="paragraph1">
																				Data without a Storage mechanism - Unimaginable!
																			</p>
																			<p class="paragraph1">
																				Get Ready to RAID the deep mines of data housing and put your skills to the test!!
																			</p>
																			<p class="paragraph1">
																				"Data is what distinguishes the dilettante from the artist." - George V. Higgins
																			</p>
																			<p class="paragraph1">
																				<b>Prize: </b> Will be announced.
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<ul class="liststyle1">
																				<li>Events consists of 2 rounds</li>
																				<li>
																					<p class="paragraph1">
																						<b>DB Hunt:</b>
																					</p>
																					<p class="paragraph1">
																						Written MCQ\'s - 30 questions
																					</p>
																					<p class="paragraph1">
																						Rapid RAID
																					</p>
																					<p class="paragraph1">
																						Quiz / Query Execution (Live Execution on machines).
																					</p>
																				</li>
																				<li>
																					<p class="paragraph">
																						<b>Database RAIDer:</b>
																					</p>
																					<p class="paragraph">
																						ER Diagram and normalized Relational schema for the given scenario must be designed.
																					</p>
																				</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>Maximum 2 per team</li>
																				<li>Every participant must <b>register</b> at the <b>hospitality desk</b> before the event starts</li>
																				<li>We will need your <b>College ID</b> card for this</li>
																				<li>30 mins for the first round </li>
																				<li>For second round ( around 10 teams) , 45 mins</li>
																				<li>Last round 30 mins</li>
																			</ul>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Kanaga</div>
																				<div class="spannumber">+91 9790791389</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Kalidha Kani</div>
																				<div class="spannumber">+91 9790942986</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Henry Jones</div>
																				<div class="spannumber">+91 9566755423</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">raid@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'events/onsite/scriptit':
			sleep(2);
			$content = array(
								'title' => 'Script IT - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">SCRIPT IT</h1>
																	<img src="images/cover/scriptit.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">FAQ</a></li>
																			<li><a href="javascript:void(0);" class="tab5">Contact</a></li>
																			<li><a href="javascript:void(0);" class="tab6">Register</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				Script IT is the onsite application development marathon where we do not restrict participants to a single platform.They can use their skills and extend their capabilities to develop a productive application related to the theme given on the spot.This event is a competitive arena to compete with fellow developers and showcase your talents.
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<ul class="liststyle1">
																				<li>Night Event (accommodation will be provided)</li>
																				<li><b>Event Timing:</b> March 1, 6 P.M. to March 2, 10 A.M. </li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>Each team can consist of a minimum of one member and a maximum of two members</li>
																				<li>The participants need not necessarily be from the same institution/college</li>
																				<li>All participants <b>must</b> have a valid Itrix ID to participate</li>
																				<li>The participants are not allowed to bring any additional material</li>
																				<li>Teams involved in any kind of malpractice will be immediately disqualified</li>
																				<li>Decisions made by the judges will be final and binding</li>
																			</ul>
																			<p class="paragraph1">
																				Itrix ID\'s will be provided during registration. We will need your college ID card for this.
																			</p>
																		</div>
																		<div id="tab4" class="none">
																			<dl class="faq">
																				<dt>Only web applications are allowed ?</dt>
																				<dd>
																					No.you can create applications for any platform.
																				</dd>
																			</dl>
																		</div>
																		<div id="tab5" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Vinothkumar</div>
																				<div class="spannumber">+91 9751293420</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Sathya Bala Raghavendar</div>
																				<div class="spannumber">+91 9944333410</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Sudarson</div>
																				<div class="spannumber">+91 8056077127</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">scriptit@itrix.in</div>
																			</div>
																		</div>
																		<div id="tab6" class="none">
																			<p class="paragraph1">
																				<a href="https://docs.google.com/forms/d/1Mcem7MriAaKxpVmmCjCjpZ47xjdsulkzPjJGBW_otUI/viewform?sid=751d210e770b5eb4&token=F8gIBz0BAAA.FTyJe4tCKGOAInow4ZFo3Q._9xsd7zwUk73JbsKFpaxag" target="_blank">Click Here to Register</a>
																			</p>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'events/onsite/theprotocol':
			sleep(2);
			$content = array(
								'title' => 'The Protocol - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">THE PROTOCOL</h1>
																	<img src="images/cover/prot.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				Need a platform to showcase your inner geek?!!
																			</p>
																			<p class="paragraph1">
																				Then "The Protocol" is just the place for you guys !! 
																			</p>
																			<p class="paragraph1">
																				Questions will be thrown from every single core concept of Computer science ( OS , Networks , Automata etc ). Get ready to shine through this event. Register soon and challenge yourself by asking the question
																			</p>
																			<p class="paragraph1">
																				Are you ready to conquer "The protocol"?!!
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<p class="paragraph1">
																				<b>Preliminary Round</b>
																			</p>
																			<ul class="liststyle1">
																				<li>Basic quantitative aptitude questions from Networks, OS, Automata </li>
																				<li>Based on the performance, top teams will be selected for next round.</li>
																			</ul>
																			<p class="paragraph1">
																				<b>FInal Round</b>
																			</p>
																			<ul class="liststyle1">
																				<li>Purely design oriented</li>
																				<li>Questions will be asked on design of systems (Core concepts only)</li>
																				<li>Operating  Systems like synchronisation, and some Networking algorithm</li>
																				<li>Knowledge of Shell programming is an added advantage</li>
																				<li>Unlimited Creativity scores more.</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>Maximum two members per team</li>
																				<li>Every participant must <b>register</b> at the <b>hospitality desk</b> before the event starts</li>
																				<li>We will need your <b>College ID</b> card for this</li>
																				<li>Lone wolves are also encouraged</li>
																				<li>The event will be held in two rounds - a preliminary round and a final round.</li>
																				<li>Usage of Internet is prohibited</li>
																				<li>Any form of malpractice will result in immediate elimination</li>
																			</ul>
																			<p class="paragraph">
																				* - ITrix ID\'s will be provided during registration. We will need your college ID card for this.
																			</p>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Boopal Sridhar</div>
																				<div class="spannumber">+91 9500378873</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Eswaran</div>
																				<div class="spannumber">+91 9944908803</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">theprotocol@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;

		case 'events/onsite/webprodigy':
			sleep(2);
			$content = array(
								'title' => 'Web Prodigy - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">WEB PRODIGY</h1>
																	<img src="images/cover/webprod.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">FAQ</a></li>
																			<li><a href="javascript:void(0);" class="tab5">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				"The Web is a platform, like a piece of paper. It does not determine what you will do with it, but it challenges your imagination" - Tim Berners Lee
																			</p>
																			<p class="paragraph1">
																				User Interface Design is a key factor that can affect product acceptance / rejection. Showcase your ability to create attractive websites in this event. All you need is a little know-how in HTML, CSS & Java Scripts.
																			</p>
																			<p class="paragraph1" style="font-size: 30px;">
																				The winners of this event will get internship offer at <b>KoolKart</b>.
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<p class="paragraph1">
																				The Event consists of three rounds
																			</p>
																			<ul class="liststyle1">
																				<li>First round will be prelims (a written test) which contains questions from HTML, CSS, Java Scripts, PHP and other web technologies. Time duration : 45 min.</li>
																				<li>Second round will be a practical test. An exact replica of a given web page must be created within the given time duration. Time duration : 30 min.</li>
																				<li>Third round : A website for a given theme must be developed. Time duration : 45 min</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>Maximum two members per team</li>
																				<li>The participants needn\'t be from the same institution/college.</li>
																				<li>Every participant must <b>register</b> at the <b>hospitality desk</b> before the event starts</li>
																				<li>We will need your <b>College ID</b> card for this</li>
																				<li>No contestant can be a member of more than one team.</li>
																				<li>Preliminary round requires no registration</li>
																				<li>The participants are not allowed to bring any additional material.</li>
																				<li>Teams involving in any kind of malpractice will immediately be disqualified.</li>
																				<li>Decisions made by the judges will be final and binding.</li>
																			</ul>
																		</div>
																		<div id="tab4" class="none">
																			<dl class="faq">
																				<dt>Is this a team event?</dt>
																				<dd>
																					Yes, A team can consist of maximum 2 members. Being a lone wolf is your wish.
																				</dd>
																				<dt>Should I bring a laptop?</dt>
																				<dd>
																					No. Computers with required facilities will be provided. Internet access is NOT allowed.
																				</dd>
																				<dt>What tools will be provided?</dt>
																				<dd>
																					Dream weaver, Xampp, Photoshop.
																				</dd>
																			</dl>
																		</div>
																		<div id="tab5" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Arun Ram</div>
																				<div class="spannumber">+91 9789556465</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Elakya</div>
																				<div class="spannumber">+91 8056292343</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">webprodigy@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'events/online/clickit!':
			sleep(2);
			$content = array(
								'title' => 'Click IT! - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">CLICK IT!</h1>
																	<img src="images/cover/photo.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				Time to unleash the photographer within you!
																			</p>
																			<p class="paragraph1">
																				Here comes an online photography contest to showcase your photography talent. Let us see how creative you can be with your camera. So just \'Click IT\'!
																			</p>
																			<p class="paragraph1">
																				<b>Theme(s)</b>: People/Architecture/Design
																			</p>
																			<p class="paragraph1">
																				Observe the world around you and find your inspiration among people or architecture or a design and show us your photography talent by capturing either one of these subjects.
																			</p>
																			<p class="paragraph1">
																				Photographs of people in different contexts offer various social, cultural & aesthetic values. Architecture or design offers diverse photographic possibilities like capturing beauty, geometry or minute detail of any structure, building or object from different perspectives & angles.
																			</p>
																			<p class="paragraph1">
																				<b>Prize :</b> Will be declared soon
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<ul class="liststyle1">
																				<li>Limit is <b>one entry per person</b> in the contest.</li>
																				<li>Contest <b>starts from January 31,2013 10:00 am</b> and <b>ends on February 26,2013 10:00 pm</b>.Any enteries posted before/after this period will not be considered in the contest.</li>
																				<li>Contestant should post his/her entry on our <b>facebook page</b> (https://www.facebook.com/itrixceg) and also mail the same entry to our email id- <b>itrix2013@gmail.com</b> (do add- caption for photo,your name,your email id, camera/mobile model used).<br><br><b>Note:</b> It is mandatory to mail the entry photo to us,ptherwise your entry will not be considered in the contest.Watermarks are acceptable.We will ensure that the photo is not misused.</li>
																				<li>Enteries will be judged by the number of likes on facebook as well as judges decision.Judges decision will will be binding,and any sort of arguments will not be entertained.</li>
																				<li>It is mandatory to give a caption,your name,your email and mention the camera/mobile model name used for the entry - <b>in the facebook post as well as in mail</b>.</li>
																				<li>Any inappropriate images will be discarded without notice.</li>
																				<li>Entry will be discarded without notice, if any photo-editing software is used for enhancement.</li>
																				<li>The winner will be contacted via Facebook for prize payment details.</li>
																				<li>The winner may be asked to produce necessary information needed to make sure the photograph is his/her authentic work.</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Gourav J</div>
																				<div class="spannumber">+91 9962889690</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Siddharth U</div>
																				<div class="spannumber">+91 9884945304</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Karthik</div>
																				<div class="spannumber">+91 9884096976</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">clickit@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
		
		case 'events/online/codeconundrum':
			sleep(2);
			$content = array(
								'title' => 'Code Conundrum - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">CODE CONUNDRUM</h1>
																	<img src="images/cover/fixit.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">FAQ</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab5">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				Do you have the knowledge to code anything under the sun ?!!
																			</p>
																			<p class="paragraph1">
																				Do you possess the courage to face challenges and propose innovative solutions ?!!
																			</p>
																			<p class="paragraph1">
																				Do you possess the will to decode the problem within the given stipulated time ?!!
																			</p>
																			<p class="paragraph1">
																				Then "CODE CONUNDRUM" is the place for you !!
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<dl class="faq">
																				<dt>When is the event slated to take place?</dt>
																				<dd>
																					27th February <a href="http://www.timeanddate.com/worldclock/fixedtime.html?msg=ITRIX+Online+Programming+Contest&iso=20130227T20&p1=553&ah=5">20:00 IST</a>.
																				</dd>
																				<dt>Where will the contest be held?</dt>
																				<dd>
																					<a href="http://www.spoj.com/ITRIX13">www.spoj.com/ITRIX13</a>.
																				</dd>
																				<dt>I\'m new to SPOJ. Where can I practice?</dt>
																				<dd>
																					<a href="http://www.spoj.com/IT3">here</a>.
																				</dd>
																				<dt>Eligibility criteria?</dt>
																				<dd>
																					&bull; Open to all college students with valid college ID cards<br>
																					&bull; Participants should have registered on the Itrix website prior to the start of the event.
																				</dd>
																				<dt>Teams Allowed?</dt>
																				<dd>
																					Nope. Strictly individual event.
																				</dd>
																			</dl>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>The Contest will be held on SPOJ</li>
																				<li>It is a single round event</li>
																				<li>Duration - 5 hour</li>
																			</ul>
																		</div>
																		<div id="tab4" class="none">
																			<ul class="liststyle1">
																				<li>Strictly individual event.</li>
																				<li>Participants should have registered on the ITrix website prior to the start of the event</li>
																				<li>Open to all college students with valid college ID cards</li>
																				<li>The contestants should be well versed in SPOJ</li>
																			</ul>
																		</div>
																		<div id="tab5" class="none">
																			<div class="contactdivision">
																				<div class="spanmail">codeconundrum@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'events/online/chamberofsecrets':
			sleep(2);
			$content = array(
								'title' => 'Chamber of Secrets - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">CHAMBER OF SECRETS</h1>
																	<img src="images/cover/cos.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab3">FAQ</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				<b>"To date, treasure-hunters have followed up clue after clue, including a dagger-marked tree, to no avail. If there is a fortune buried in Handcart Gulch, it is still safely hidden"</b> - Phyllis Flanders Dorset
																			</p>
																			<p class="paragraph1">
																				Are you someone who has Google on his fingertips? Do you often find yourself able to finish things quickly and efficiently just because you could navigate the intricate webs of the Internet to get where you want and what you wanted? Then this is the game for you.
																			</p>
																			<p class="paragraph1">
																				<a href="http://cos.itrix.in/" target="_blank">http://cos.itrix.in/</a>
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<ul class="liststyle1">
																				<li>This is a lone wolf event.</li>
																				<li>This will be a online event</li>
																				<li>No Teamwork shall be encouraged and if caught, all parties involved in cheating will be banned/disqualified immediately and/or publicly humiliated.</li>
																				<li>There will be 20 questions of varying difficulty.</li>
																				<li>The link will be published shortly.</li>
																			</ul>																		
																		</div>
																		<div id="tab3" class="none">
																			<dl class="faq">
																				<dt>Sir, I am new to Online Treasure Hunts and Chamber of Secrets. What can I do to prepare?</dt>
																				<dd>
																					This event requires absolutely no preparation. Be sure to put on your thinking cap throughout the hunt. A trial run will be launched a week prior to COS Season 1, which will help you get accustomed to online treasure hunting.
																				</dd>
																				<dt>Sir, Is there any sites/learning material?</dt>
																				<dd>
																					Wikipedia and Google. Also, you must have Patience and a dynamic, flexible mind.
																				</dd>
																				<dt>Sir, How long will it take to do CoS? Can I finish it in 1 hr and then go waste my time on Facebook like always?</dt>
																				<dd>
																					Please don\'t assume that you will solve all puzzles in one session; you\'ll probably be coming back to the hunt page several times over days or weeks as your brain makes intuitive leaps to solve the puzzles. CoS players have been known to get quite addicted to the game and last year we had some people sitting for 3-4 days just one one level doing nothing else. You have been warned.
																				</dd>
																			</dl>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Mohit Bagde</div>
																				<div class="spannumber">+91 9444938700</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Chandresh</div>
																				<div class="spannumber">+91 9791793004</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">cos@itrix.in</div>
																			</div>
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_events.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'workshops':
			sleep(2);
			$content = array(
								'title' => 'Workshops | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">WORKSHOPS</h1>
																</header>
																<p class="paragraph1">
																	<b>"All the breaks you need in life lie in wait within your imagination, Imagination is the workshop of your mind, capable of turning mind energy into accomplishment and wealth. "</b> - Napoleon Hill 
																</p>
																<p class="paragraph1">
																	At ITrix 2013, Workshops are hands-on, interactive sessions that provide an opportunity to learn new skills or hone existing ones. Emphasis is placed on examples from emerging markets, fortune 500 companies, sharing experiences between attending institutions, and building strong professional relationships.
																</p>
																<p class="paragraph1">
																	These workshops provide a platform for more than 10,000 young minds from not only India\'s but also the world\'s top institutions to bring forth their innovative thoughts and ideas and model them into working systems, guided by technical experts, for the betterment of the society at large by encouraging innovation through technology.
																</p>
																<p class="paragraph1">
																	Be transported to a world of innovation. Come, be a part of the ITrix 2013 Workshops!
																</p>
																<p class="paragraph1">
																	Take a whiff of ITrix \'13 Events!!! It\'s now or never!!
																</p>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_workshops.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'workshops/bigdata':
			sleep(2);
			$content = array(
								'title' => 'Big Data - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">BIG DATA</h1>
																	<img src="images/cover/bigdata2.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Benefits</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab5">FAQ</a></li>
																			<li><a href="javascript:void(0);" class="tab6">Contact</a></li>
																			<li><a href="javascript:void(0);" class="tab7">Registration</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				Generation of over 2.5 quintillion bytes of data everyday makes on-hand processing complex and challenging. Analysis of large data sets, or \'big data\', is becoming a crucial business requirement, underpinning new waves of growth and innovation. Leaders in every sector are now grappling with the implications of big data. Seemingly overnight, it has evolved from something that was the realm of a select number of data-savvy managers to an urgent business imperative that can give you the edge on your competitors. Learn how such data is handled and analyzed and why this technology has taken the world by storm. 
																			</p>
																			<p class="paragraph1">
																				This workshop, conducted by IBM, is suitable for executives, analysts and business professionals in any organization interested in leveraging data to make better decisions. Analysts will gain knowledge and tools for making smarter decisions and business professionals will emerge from the workshop with a solid grounding in business analytics and predictive analytics.
																			</p>
																			<p class="paragraph1">
																				<b>Student Workshop Fee:</b> Rs.500 (4 hrs)<br>
																				<b>Corporates Workshop Fee:</b> Rs.800 (4 hrs)
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<ul class="liststyle1">
																				<li>Navigate the complex analytics landscape</li>
																				<li>Gain insights into how, where and why analytic techniques are used with case studies from Fortune 500 companies</li>
																				<li>Manage the risks of data analysis</li>
																				<li>Gain a competitive edge by putting analytics into a business context</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<p class="paragraph1">
																				A one day workshop on March 2, 2013
																			</p>
																		</div>
																		<div id="tab4" class="none">
																			<ul class="liststyle1">
																				<li>Every participant must register at the hospitality desk before the event starts</li>
																				<li>We will need your College ID card for this</li>
																			</ul>																		
																		</div>
																		<div id="tab5" class="none">
																			<dl class="faq">
																				<dt>Prior knowledge, preparation - Encouraged but not essential</dt>
																				<dd></dd>
																				<dt>Laptops - Not essential but may prove useful for a hands-on experience</dt>
																				<dd></dd>
																				<dt>Certificates will be provided</dt>
																				<dd></dd>
																			</dl>
																		</div>
																		<div id="tab6" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Apsara</div>
																				<div class="spannumber">+91 9600103546</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Anugrah</div>
																				<div class="spannumber">+91 9884177916</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">bigdata@itrix.in</div>
																			</div>
																		</div>
																		<div id="tab7" class="none">
																			'.$workshop_registration['bigdata'].'
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_workshops.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
	
	case 'workshops/windows8appdevelopment':
			sleep(2);
			$content = array(
								'title' => 'Windows 8 App Development - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">WINDOWS 8 APP DEVELOPMENT</h1>
																	<img src="images/cover/win8.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">FAQ</a></li>
																			<li><a href="javascript:void(0);" class="tab5">Contact</a></li>
																			<li><a href="javascript:void(0);" class="tab6">Registration</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				WINDOWS 8. MILLIONS OF PEOPLE. YOUR APP.
																			</p>
																			<p class="paragraph1">
																				Seizing the opportunity is easier than you think.
																			</p>
																			<p class="paragraph1">
																				Now that Windows 8 is here, there\'s never been a better time to build apps. Right from the start to the finish, this workshop will provide what you need to make coding Windows 8 apps or games a snap. Find the tools, help, and support you need to create your app.
																			</p>
																			<p class="paragraph1">
																				<b>Student Workshop Fee:</b> Rs.500 (4 hrs)<br>
																				<b>Corporates Workshop Fee:</b> Rs.800 (4 hrs)
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<p class="paragraph1">
																				A one session workshop on March 2, 2013.
																			</p>
																		</div>
																		<div id="tab3" class="none">
																			<ul class="liststyle1">
																				<li>Every participant must register at the hospitality desk before the event starts</li>
																				<li>We will need your College ID card for this</li>
																			</ul>																		
																		</div>
																		<div id="tab4" class="none">
																			<dl class="faq">
																				<dt>Do we have to know anything about app development prior to attending the workshop?</dt>
																				<dd>
																					No it is not mandatory. Anyone who can perform can come and learn.
																				</dd>
																				<dt>Do we have to bring laptops?</dt>
																				<dd>
																					It is not mandatory but we advise you to bring your laptops to have a hands-on experience
																				</dd>
																				<dt>Will we be provide a certificate?</dt>
																				<dd>
																					Yes.
																				</dd>
																			</dl>
																		</div>
																		<div id="tab5" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Muralidhar Reddy</div>
																				<div class="spannumber">+91 7708656853</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Goutham Raam</div>
																				<div class="spannumber">+91 9789842757</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Madhava Raj</div>
																				<div class="spannumber">+91 9677077398</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">windows8@itrix.in</div>
																			</div>
																		</div>
																		<div id="tab6" class="none">
																			'.$workshop_registration['win8appdev'].'
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_workshops.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'workshops/cyberforensics':
			sleep(2);
			$content = array(
								'title' => 'Cyber Forensics - Events | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">CYBER FORENSICS</h1>
																	<img src="images/cover/cyb2.png"/>
																</header>
																<section class="tabbedholder">
																	<nav class="tabbednavigation">
																		<ul>
																			<li><a href="javascript:void(0);" class="tab1">Home</a></li>
																			<li><a href="javascript:void(0);" class="tab2">Format</a></li>
																			<li><a href="javascript:void(0);" class="tab3">Rules</a></li>
																			<li><a href="javascript:void(0);" class="tab4">Contact</a></li>
																			<li><a href="javascript:void(0);" class="tab5">Registration</a></li>
																		</ul>
																	</nav>
																	<article class="tabbedcontentholder">
																		<div id="tab1">
																			<p class="paragraph1">
																				<b>"If you think technology can solve your security problems, then you don\'t understand the problems and you don\'t understand the technology"</b> - Bruce Schneier
																			</p>
																			<p class="paragraph1">
																				<b>Student Workshop Fee:</b> Rs.600 (8 hrs)<br>
																				<b>Corporates Workshop Fee:</b> Rs.900 (8 hrs)
																			</p>
																			<p class="paragraph1">
																				The threats in usage of modern technology remain seriously under-appreciated by most. Wanna learn to navigate the maze of cyber security to its depths? Here we arm you with the knowledge and skill to do so
																			</p>
																			<p class="paragraph1">
																				<b>About Tech Bharat Consulting</b>
																			</p>
																			<p class="paragraph1">
																				TechBharat Consulting (Thakral Info Security Services) is an Accredited Training Centre for EC Council USA, who is a member-based organization that certifies individuals in various e-business and information security skills.It has solved many cases like Fake Profile Cases, Email Spoofing cases, Phishing case, Espionage cases, Credit Card fraud Cases, SMS Spoofing Case in association with many Security Agencies.
																			</p>
																			<p class="paragraph1">
																				<b>About the workshop</b>
																			</p>
																			<p class="paragraph1">
																				This workshop demonstrates the latest ethical hacking and cyber forensics techniques by Tech Bharat Consulting.
																			</p>
																			<p class="paragraph1">
																				Learn to Scan,Test,Hack and Secure your own systems!
																			</p>
																			<p class="paragraph1">
																				Lab Intensive Environment and Hands-On Experiments will give in-depth knowledge and practical experience with current essential security systems!
																			</p>
																			<p class="paragraph1">
																				Along with knowledge, take away <b>Ethical hacking and Cyber Forensics toolkit and Information Security Professional Certificate.</b>
																			</p>
																		</div>
																		<div id="tab2" class="none">
																			<p class="paragraph1">
																				
																			</p>
																			<ul class="liststyle1">
																				<li>This is a one-day workshop on March 1, 2013 (8 hrs).</li>
																				<li>WILD CARD ENTRY into National ethical championship for contest winners</li>
																				<li>Contest will be kept.Winners will be provided DISCOUNT vouchers for tech bharat\'s training</li>
																			</ul>
																			<p class="paragraph1">
																				<b>Session</b>
																			</p>
																			<ul class="liststyle1">
																				<li>Basics of Information Security Terminologies</li>
																				<li>Spoofing Series</li>
																				<li>Email Hacking and Forensics</li>
																				<li>Computer Hacking and Forensics</li>
																				<li>Google Hacking and Social Engineering</li>
																				<li>Trojan and Backdoors</li>
																				<li>Session Hijacking</li>
																				<li>Website Hacking and Security</li>
																			</ul>
																		</div>
																		<div id="tab3" class="none">
																			<p class="paragraph1">
																				<b>Eligibility criterion:</b>
																			</p>
																			<ul class="liststyle1">
																				<li>Every participant must register at the hospitality desk before the event starts</li>
																				<li>We will need your College ID card for this</li>
																			</ul>	
																			<p class="paragraph1">
																				<b>Participation:</b>
																			</p>
																			<p class="paragraph1">
																				Participants can be from any discipline and  have to register individually for the workshop.
																			</p>
																			<p class="paragraph1">
																				<b>Pre-requisites:</b>
																			</p>
																			<p class="paragraph1">
																				There are no pre-requisites for this workshop.
																			</p>
																			<p class="paragraph1">
																				<b>Cost details:</b>
																			</p>
																			<p class="paragraph1">
																				The cost of the workshop is INR 600/- (or) INR 900/-. The details of the payment will be intimated to the shortlisted participants through e-mail.
																			</p>
																			<p class="paragraph1">
																				<b>Certificate Criterion:</b>
																			</p>
																			<p class="paragraph1">
																				Certificates will be provided to the participants only if he/she attends all the sessions of the workshop. Failing to do so, the participant\'s registration will be cancelled and he/she will also forfeit the registration fee.
																			</p>
																		</div>
																		<div id="tab4" class="none">
																			<div class="contactdivision">
																				<div class="spanname">Sharanya</div>
																				<div class="spannumber">+91 9840235855</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Reshma</div>
																				<div class="spannumber">+91 9840317684</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanname">Vanathi</div>
																				<div class="spannumber">+91 9790032907</div>
																			</div>
																			<div class="contactdivision">
																				<div class="spanmail">cyber@itrix.in</div>
																			</div>
																		</div>
																		<div id="tab5" class="none">
																			'.$workshop_registration['cyberforensics'].'
																		</div>
																	</article>
																</section>
															</section>
															<aside class="rightsidebarnavigation">
																'.$menu_workshops.'
																'.$logoutbutton.'
															</aside>
														</article>
													'
								);
			break;
			
		case 'profile':
			if(!isset($authorisation) && empty($authorisation))
			{
				sleep(2);
				$content = array(
									'title' => 'Not Authorised | ITRIX 2013',
									'.pageholder' => 	'
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">NOT AUTHORISED</h1>
																</header>
															</section>
														</article>
													'
								);	
			}
			else
			{
				sleep(2);
				$content = array(
									'title' => 'Profile | ITRIX 2013',
									'.pageholder' => 	'
														<article class="levelholder">
															<section class="maincontentblockholder">
																<header>
																	<h1 class="title">PROFILE</h1>
																</header>
															</section>
														</article>
														<article class="levelholder">
															<form class="profileform">
																<input type="text" placeholder="Name" name="name" value="'.$userdata['name'].'" title="Full Name as in Certification"/>
																<input type="text" placeholder="Email" name="email" value="'.$userdata['email'].'" disabled title="Email Address cannot be edited."/>
																<input type="text" placeholder="Landline/Mobile Number" name="phonenumber" value="'.$userdata['phonenumber'].'" title="Landline/Mobile Number"/>
																<input type="text" placeholder="Organisation/Institution Name" name="organisationname" value="'.$userdata['organisationname'].'" title="Organisation/Institution/College/School Name"/>
																<div class="profilestatusholder">
																	<div class="profilesavestatus">Saved</div>
																</div>
															</form>
														</article>
															
													'
								);	
			}
			break;
		
		case 'aboutus':
			sleep(2);
			$content = array(
								'title' => 'About Us | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="fullcontentblockholder">
																<header>
																	<h1 class="title">ABOUT US</h1>
																</header>
																<div class="fullcontentblock">
																	<div class="blocksection">
																		<header>
																			<h1>CEG & AU</h1>
																		</header>
																		<img src="images/aboutus/ceg.png"/>
																		<p>
																			College of Engineering, Guindy consistently ranks among the top 10 colleges of India. Established in the year 1794, College of Engineering, Guindy has a n inexorable tradition of grooming the brightest minds of the nation into smart engineers and executives who can think on their feet.
																		</p>
																		<p>
																			Anna University (AU), formerly Perarignar Anna University of Technology (PAUT), is a technical university in Tamil Nadu, India. It\'s been ranked 5th best university in India. The university encompasses within it one of the oldest technical institutes in the world and has a history spanning 218 years [as of 2012]. It was renamed \'Anna University\' on 4 September 1978 as a unitary university, named after C. N. Annadurai. It became an affiliating university in 2001, absorbing about 250 engineering colleges in Tamil Nadu. Between 2007 and 2010 it was split into six universities, namely, Anna University, Chennai, Anna University of Technology, Chennai, Anna University of Technology, Tiruchirappalli, Anna University of Technology, Coimbatore, Anna University of Technology Tirunelveli and Anna University of Technology, Madurai. On September 14, 2011 a bill was passed to merge back the universities. Anna University has once again become a single affiliating university for engineering colleges all over Tamil Nadu from August 1, 2012.
																		</p>
																	</div>
																	<div class="blocksection">
																		<header>
																			<h1>ITRIX & ISTA (DIST)</h1>
																		</header>
																		<p>
																			The Information Science and Technology Association (ISTA) is honoured to present ITrix, the annual technical fest of the Department of Information Science and Technology (DIST) , College of Engineering Guindy , Anna University, Chennai. ITrix has every ingredients of a successful techfest with fascinating and novel events, thought provoking workshops adding to the flavor.
																		</p>
																		<p>
																			Information Science and Technology Association is one of the vibrant and active associations of Anna University. ISTA organizes ITRIX every year to perfection which pulls thousands of students from various corners of the globe. The Online Programming Contest of ITRIX was a mega hit with participants from over 40 countries.
																		</p>
																		<p>
																			ISTA also organized the first version of i++ - intra-college technical techfest which evoked overwhelming response from the students. For an intra-college techfest, i++ offered too much brain food that the student community was forced to sharpen their skills.
																		</p>
																		<p>
																			Department of Information Science and Technology is one of the youngest and fastest growing departments of Anna University. It also remains as the dream destination for many aspiring students of the state.
																		</p>
																	</div>
																</div>
															</section>
														</article>
													'
								);
			break;
			
		case 'sponsors':
			sleep(2);
			$content = array(
								'title' => 'Sponsors | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="fullcontentblockholder">
																<header>
																	<h1 class="title">SPONSORS</h1>
																</header>
																<div class="fullcontentblock">
																	<a href="pdf/ITrix13.pdf">Download our brochure.</a>
																</div>
																<div class="fullcontentblock">
																	<!--div class="boxes">
																		<h1 class="contactsectiontitle">TITLE PARTNER</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="">
																						<img src="images/sponsors/sponsor.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>										
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">ASSOCIATE SPONSOR</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="">
																						<img src="images/sponsors/sponsor.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>										
																	</div--!>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">ASSOCIATE SPONSOR</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.inplanttraining.org/" target="_blank">
																						<img src="images/sponsors/current/associate/uniq.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																			<li class="second-child">
																				<div class="curve-down">
																					<a href="http://www.tnpl.com/" target="_blank">
																						<img src="images/sponsors/current/associate/tnpl.PNG" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">EVENT PARTNER</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.jetkinginfotrain.com/" target="_blank">
																						<img src="images/sponsors/current/events/jetkings.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																			<li class="second-child">
																				<div class="curve-down">
																					<a href="http://www.indix.com/" target="_blank">
																						<img src="images/sponsors/current/events/indix.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																			<li class="third-child">
																				<div class="curve-down">
																					<a href="http://www.amazon.com/" target="_blank">
																						<img src="images/sponsors/current/events/amazon.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																			<li class="last-child">
																				<div class="curve-down">
																					<a href="http://emo2.com/" target="_blank">
																						<img src="images/sponsors/current/events/emo2.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="#" target="_blank">
																						<img src="images/sponsors/current/events/jctrust.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																			<li class="second-child">
																				<div class="curve-down">
																					<a href="http://www.nsic.co.in/" target="_blank">
																						<img src="images/sponsors/current/events/nsic.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																			<li class="third-child">
																				<div class="curve-down">
																					<a href="http://www.elcot.in/" target="_blank">
																						<img src="images/sponsors/current/events/elcot.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">WORKSHOP PARTNER</h1>
																		<ul>
																			<!--li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.microsoft.com/en-in/default.aspx" target="_blank">
																						<img src="images/sponsors/current/workshops/microsoft.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li-->
																			<li class="second-child">
																				<div class="curve-down">
																					<a href="http://www.ibm.com/in/en/" target="_blank">
																						<img src="images/sponsors/current/workshops/ibm.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																			<li class="third-child">
																				<div class="curve-down">
																					<a href="http://www.techbharat.org/" target="_blank">
																						<img src="images/sponsors/current/workshops/techbharat.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																			<!--li class="last-child">
																				<div class="curve-down">
																					<a href="">
																						<img src="images/sponsors/sponsor.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li-->
																		</ul>										
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">MEDIA PARTNER</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.aahaafm.com/" target="_blank">
																						<img src="images/sponsors/current/media/aahaa.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">HOSPITALITY SPONSOR</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.ntltaxi.com/" target="_blank">
																						<img src="images/sponsors/current/hospitality/ntl.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">STALL SPONSOR</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.iob.in/" target="_blank">
																						<img src="images/sponsors/current/stall/iob.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																			<li class="second-child">
																				<div class="curve-down">
																					<a href="http://time4education.com/" target="_blank">
																						<img src="images/sponsors/current/stall/time.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">PROGRAMMING PARTNER</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.sphere-research.com/en/" target="_blank">
																						<img src="images/sponsors/current/programming/sphere.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>										
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">DELEGATE KIT SPONSOR</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.licindia.in/" target="_blank">
																						<img src="images/sponsors/current/delegatekit/lic.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">MEGA EVENT SPONSOR</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.newindia.co.in/" target="_blank">
																						<img src="images/sponsors/current/megaevent/nii.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>
																	</div>
																	<div class="boxes">
																		<h1 class="contactsectiontitle">TSHIRT SPONSOR</h1>
																		<ul>
																			<li class="first-child">
																				<div class="curve-down">
																					<a href="http://www.kaaviansys.com/" target="_blank">
																						<img src="images/sponsors/current/tshirt/kaavian.png" alt="" width="237" height="185" />
																					</a>
																				</div>
																			</li>
																		</ul>
																	</div>
																</div>
															</section>
														</article>
													'
								);
			break;	
			
		case 'contactus':
			sleep(2);
			$content = array(
								'title' => 'Contact Us | ITRIX 2013',
								'.pageholder' => 	' 
														<article class="levelholder">
															<section class="fullcontentblockholder">
																<header>
																	<h1 class="title">CONTACT US</h1>
																</header>
																<div class="fullcontentblock">
																	<div class="contactdivision">
																		<div class="contactfloat">
																			<div class="spanname">R.Thiagarajan</div>
																			<div class="spandes">President</div>
																			<div class="spannumber">+91 9940013277</div>
																		</div>
																		<div class="contactfloat">
																			&nbsp;
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">J.Archana</div>
																			<div class="spandes">Treasurer</div>
																			<div class="spannumber">+91 9994824675</div>
																		</div>		
																	</div>
																	<div class="contactdivision">
																		<div class="contactfloat">
																			<div class="spanname">Mohit Bagde</div>
																			<div class="spandes">Vice-President</div>
																			<div class="spannumber">+91 9444938700</div>
																		</div>
																		<div class="contactfloat">
																			&nbsp;
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Yogalakshmi</div>
																			<div class="spandes">General Secretary</div>
																			<div class="spannumber">+91 9566278752</div>
																		</div>
																	</div>
																	<hr>
																	<div class="contactdivision">
																		<h1 class="contactsectiontitle">GENERAL INFORMATION</h1>
																		<div class="contactfloat">
																			<div class="spanname">Dinesh Kumar</div>
																			<div class="spannumber">+91 9659929988</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Boopal Sridar</div>
																			<div class="spannumber">+91 9500378873</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Sabarinath S.</div>
																			<div class="spannumber">+91 9698373313</div>
																		</div>
																	</div>
																	<hr>
																	<div class="contactdivision">
																		<h1 class="contactsectiontitle">SPONSORSHIP</h1>
																		<div class="contactfloat">
																			<div class="spanname">Krishnan.E</div>
																			<div class="spannumber">+91 9566150054</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">U.Siddarth</div>
																			<div class="spannumber">+91 9884945304</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Ashok Sriram Pandian</div>
																			<div class="spannumber">+91 9790539447</div>
																		</div>
																	</div>
																	<hr>
																	<div class="contactdivision">
																		<h1 class="contactsectiontitle">MARKETING</h1>
																		<div class="contactfloat">
																			<div class="spanname">Mohammed Rameez Raja</div>
																			<div class="spannumber">+91 9566886577</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Chandramohan Samuel</div>
																			<div class="spannumber">+91 9597992923</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Aravind</div>
																			<div class="spannumber">+91 9698050596</div>
																		</div>
																	</div>
																	<hr>
																	<!--div class="contactdivision">
																		<h1 class="contactsectiontitle">EVENTS</h1>
																		<div class="contactfloat">
																			<div class="spanname">Ashok Sriram Pandian</div>
																			<div class="spannumber">+91 9790539447</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Prakash.D</div>
																			<div class="spannumber">+91 9597726205</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Vinoth  Kumar</div>
																			<div class="spannumber">+91 9751293420</div>
																		</div>
																	</div>
																	<hr>
																	<div class="contactdivision">
																		<h1 class="contactsectiontitle">WORKSHOPS</h1>
																		<div class="contactfloat">
																			<div class="spanname">Vanathi.A</div>
																			<div class="spannumber">+91 9790032907</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Muralidhar Reddy</div>
																			<div class="spannumber">+91 7708656853</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Sri Dev</div>
																			<div class="spannumber">+91 8056267892</div>
																		</div>
																	</div>
																	<hr>
																	<div class="contactdivision">
																		<h1 class="contactsectiontitle">LOGISTICS</h1>
																		<div class="contactfloat">
																			<div class="spanname">Eswaran Subbaiah</div>
																			<div class="spannumber">+91 9944908803</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Sudarson</div>
																			<div class="spannumber">+91 </div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Sathya Raghavender</div>
																			<div class="spannumber">+91 9944333410</div>
																		</div>
																	</div>
																	<hr>
																	<div class="contactdivision">
																		<h1 class="contactsectiontitle">DESIGN</h1>
																		<div class="contactfloat">
																			<div class="spanname">Hajee Akthar</div>
																			<div class="spannumber">+91 9003840388</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Santosh Kumar</div>
																			<div class="spannumber">+91 9965076699</div>
																		</div>
																	</div>
																	<hr-->
																	<div class="contactdivision">
																		<h1 class="contactsectiontitle">WEB</h1>
																		<div class="contactfloat">
																			<div class="spanname">Yuvaraja.B</div>
																			<div class="spannumber">+91 9789553811</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Chandresh	R.M.</div>
																			<div class="spannumber">+91 9791793004</div>
																		</div>
																		<!--div class="contactfloat">
																			<div class="spanname">Sanjith K.</div>
																			<div class="spannumber">+91 9578652806</div>
																		</div-->
																	</div>
																	<hr>
																	<div class="contactdivision">
																		<h1 class="contactsectiontitle">HOSPITALITY</h1>
																		<div class="contactfloat">
																			<div class="spanname">Jagadeesh M.</div>
																			<div class="spannumber">+91 9566302330</div>
																		</div>
																		<div class="contactfloat">
																			<div class="spanname">Eswar</div>
																			<div class="spannumber">+91 9944908803</div>
																		</div>
																	</div>
																</div>
															</section>
														</article>
													'
								);
			break;
	}
	
	
	if($format == "json")
		echo json_encode($content);
	else if($format == "tree")
	{
		print '<pre>';
		if (count($content>100)) 
		{
			print_r(array_slice($content,0,100));
		} 
		else 
		{
			print_r($content);
		}
		print '</pre>';
	}
	else
	{
		
	}
	
	
	$_timer->end_time();
	
?>