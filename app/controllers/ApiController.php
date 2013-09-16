<?php

class ApiController extends BaseController {

	private $aPingdomAccess = array( "ops-l@wikia-inc.com", "uK17hbrO", "39f6xuxdt784j7el5jhzfaz4rafu8ci6" );

	public function getFastly() {

		if ( Cache::has('fastly') ) {

			return Response::make( Cache::get('fastly') );

		} else {

			$region = Input::get('region');
			$service = Input::get('service');

			$curl = curl_init();

			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_CONNECTTIMEOUT => 30,
			    CURLOPT_TIMEOUT => 30,
			    CURLOPT_USERAGENT => 'Wikia Status Page',
			    CURLOPT_URL => 'http://status.fastly.com/api/v0/statuses?region='. $region .'&service='. $service
			));

			$resp = curl_exec($curl);
			
			curl_close($curl);

			if (!empty($resp)) {
				Cache::put('fastly', $resp, 10 );
				return Response::make( $resp, 200 );
			} else {
				return Response::make( $resp, 500 );
			}

		}

	}

	public function getNagios() {

		if ( Cache::has('nagios') ) {
			
			return Response::make( Cache::get('nagios'), 200 );

		} else {

			$curl = curl_init();

			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_CONNECTTIMEOUT => 30,
			    CURLOPT_TIMEOUT => 30,
			    CURLOPT_USERAGENT => 'Wikia Status Page',
			    CURLOPT_URL => 'http://monitor-s3/nagiostatus/status.php'
			));

			$resp = curl_exec($curl);

			if (!empty($resp)) {
				Cache::put('nagios', $resp, 10 );
				return Response::make( $resp, 200 );
			} else {
				return Response::make( $resp, 500 );
			}

		}

	}

	public function getPingdom() {

		if ( Cache::has('pingdom') ) {

			return Response::make( Cache::get('pingdom'), 200 );

		} else {

			// Muppet 108048
			// Main 483276

			$from = time() - ( 30 * 24 * 60 * 60 );

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api.pingdom.com/api/2.0/summary.average/108048?includeuptime=true&from=' . $from ,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_USERPWD => $this->aPingdomAccess[0] . ":" . $this->aPingdomAccess[1],
				CURLOPT_HTTPHEADER => array( "App-Key: " . $this->aPingdomAccess[2] ),
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_CONNECTTIMEOUT => 30,
			    CURLOPT_TIMEOUT => 30,
			    CURLOPT_USERAGENT => 'Wikia Status Page',
			    CURLOPT_SSL_VERIFYPEER => 0
			));

			$respMuppet = curl_exec($curl);

			curl_close($curl);

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api.pingdom.com/api/2.0/summary.average/483276?includeuptime=true&from=' . $from ,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_USERPWD => $this->aPingdomAccess[0] . ":" . $this->aPingdomAccess[1],
				CURLOPT_HTTPHEADER => array( "App-Key: " . $this->aPingdomAccess[2] ),
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_CONNECTTIMEOUT => 30,
			    CURLOPT_TIMEOUT => 30,
			    CURLOPT_USERAGENT => 'Wikia Status Page',
			    CURLOPT_SSL_VERIFYPEER => 0
			));

			$respMain = curl_exec($curl);

			curl_close($curl);

			$oMuppet = json_decode($respMuppet);
			$oMain = json_decode($respMain);

			if ( is_object($oMuppet) && is_object($oMain) ) { 
				$oMuppetSummary = $oMuppet->{'summary'}->{'status'};
				$fUptimeMuppet = round( $oMuppetSummary->{'totalup'} / ( $oMuppetSummary->{'totalup'} + $oMuppetSummary->{'totaldown'} + $oMuppetSummary->{'totalunknown'} ), 4);
			
				$oMainSummary = $oMain->{'summary'}->{'status'};
				$fUptimeMain = round( $oMainSummary->{'totalup'} / ( $oMainSummary->{'totalup'} + $oMainSummary->{'totaldown'} + $oMainSummary->{'totalunknown'} ), 4);

				$aUptime = array( 'uptime' => min( $fUptimeMain, $fUptimeMuppet ) * 100 );
				$aUptime['uptime'] .= '%';

					Cache::put('pingdom', json_encode($aUptime), 10 );
					return Response::make(json_encode($aUptime), 200);

			} else {

				$aUptime = array( 'uptime' => 'Not available' );
				return Response::make( json_encode($aUptime), 500);
			}

		}

	}

	public function destroyCache () {

		Cache::forget('fastly');
		Cache::forget('nagios');
		Cache::forget('pingdom');

	}

}