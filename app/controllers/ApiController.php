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

	public function getNagiosTest()
	{
		$resp = '[{"host_name":"Apache_Cluster","service_description":"Special Healthcheck","last_hard_state_change":"1378522620","plugin_output":"CLUSTER OK: Apache: 30 ok, 0 warning, 0 unknown, 2 critical"},{"host_name":"Thumbnailers_Cluster","service_description":"Make Thumbnail","last_hard_state_change":"1363722477","plugin_output":"CLUSTER OK: make: 32 ok, 0 warning, 0 unknown, 0 critical"},{"host_name":"wikia","service_description":"Cluster1-MW-r\/o","last_hard_state_change":"1379034257","plugin_output":"DOWN: site is in read-write mode"},{"host_name":"wikia","service_description":"Cluster2-MW-r\/o","last_hard_state_change":"1379073674","plugin_output":"DOWN: site is in read-write mode"},{"host_name":"wikia","service_description":"Cluster3-MW-r\/o","last_hard_state_change":"1379028652","plugin_output":"DOWN: site is in read-write mode"},{"host_name":"wikia","service_description":"Cluster4-MW-r\/o","last_hard_state_change":"1379024281","plugin_output":"DOWN: site is in read-write mode"},{"host_name":"wikia","service_description":"New wikis creation","last_hard_state_change":"1373500917","plugin_output":"OK: 612 new wikis created yesterday."},{"host_name":"wikia","service_description":"Sendgrid_C1_transmitted","last_hard_state_change":"1379127744","plugin_output":"QUERY OK: \'SELECT COUNT(*) from mail WHERE (attempted + 60) < NOW() AND transmitted IS NULL\' returned 0.000000"},{"host_name":"","service_description":"","plugin_output":"","last_hard_state_change":""}]';
		return Response::make( $resp, 200 );
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