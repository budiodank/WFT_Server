<?php
session_start();
class Config
	{
		protected $host		= 'localhost';
		protected $dbname 	= 'inoprexc_spa';
		protected $user	 	= 'root';
		protected $password	= 'root';

		public function connectionKey()
		{
			$mysqli = mysqli_connect($this->host,$this->user,$this->password);
			$mysqli->select_db($this->dbname);

			return $mysqli;
		}

		public function check()
		{
			$check = "Ea";
			return $check;
		}

		public function closeConnection()
		{
			$mysqli = null;
		}
		
		public function userId($lenght)
		{
			$char= '123456789abcdef';
		    $string = '';
		    for ($i = 0; $i < $lenght; $i++) {
			  $pos = rand(0, strlen($char)-1);
			  $string .= $char{$pos};
		    }
		    return $string;
		}
		
		public function addTechnician($userId, $name, $address, $telp_no, $username, $password, $level, $date)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("INSERT INTO users SET id = '$userId', name = '$name', address = '$address', telp_no = '$telp_no', username = '$username', password = '$password', level = '$level', created_dt = '$date', updated_dt = '$date'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}
		
		public function selTechnician()
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("SELECT * FROM users ORDER BY name ASC");

			if ($query) {
				//echo "<script>alert('GET DATA')</script>";
			} else {
				echo "<script>alert('FAILED')</script>";
			}

			return $query;
		}
		
		public function upTechnician($id, $name, $address, $telp_no, $date)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("UPDATE users SET name = '$name', address = '$address', telp_no = '$telp_no', updated_dt = '$date' WHERE id = '$id'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}
		
		public function delTechnician($id)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("DELETE users WHERE id = '$id'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}
		
		public function getTechnician($id)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("SELECT * FROM users WHERE id = '$id'");

			if ($query) {
				//echo "<script>alert('GET DATA')</script>";
			} else {
				echo "<script>alert('FAILED')</script>";
			}

			return $query;
		}
		
		public function login($username,$password)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
			
			$row = mysqli_num_rows($query);

			if ($row  > 0) {
				return $query;
			} else {
				return $query = false;
			}

			
		}
		
		public function addTools($id, $name, $lat, $lng, $description, $created_by, $date)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("INSERT INTO tools SET id = '$id', name = '$name', lat = '$lat', lng = '$lng', description = '$description', created_by = '$created_by', created_dt = '$date', updated_by = '$created_by',updated_dt = '$date'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}

		public function selTools()
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("SELECT * FROM tools ORDER BY name ASC");

			if ($query) {
				//echo "<script>alert('GET DATA')</script>";
			} else {
				echo "<script>alert('FAILED')</script>";
			}

			return $query;
		}
		
		public function upTools($id, $name, $lat, $lng, $description, $created_by, $date)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("UPDATE tools SET name = '$name', lat = '$lat', lng = '$lng', description = '$description', created_by = '$created_by', created_dt = '$date', updated_by = '$created_by',updated_dt = '$date' WHERE id = '$id'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}
		
		public function delTools($id)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("DELETE tools WHERE id = '$id'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}
		
		public function addToolDtl($tool, $vibration, $water_flow, $water_level, $relay, $date, $status)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("INSERT INTO tools_detail SET tools_id = '$tool', vibration = '$vibration', water_flow = '$water_flow', water_level = '$water_level', relay = '$relay', created_dt = '$date', status = '$status'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}
		
		public function toolDtl($action, $time_c)
		{
			$callConn = $this->connectionKey();

			$query = "";

			if ($action == "all") {
				$query = $callConn->query("SELECT a.tools_id, a.vibration, a.water_flow, a.water_level, a.relay, a.created_dt, b.name, b.lat, b.lng, b.description FROM tools_detail a JOIN tools b ON a.tools_id = b.id WHERE LEFT(CURDATE(), 10) = LEFT(a.created_dt, 10) ORDER BY b.id");
			} else if ($action == "sum") {
				$query = $callConn->query("SELECT a.tools_id, IFNULL(a.vibration_problem,0) vibration_problem, IFNULL(a.vibration_normal,0) vibration_normal,
                                    IFNULL(b.water_flow_problem,0) water_flow_problem, IFNULL(b.water_flow_normal,0) water_flow_normal,
                                    IFNULL(c.water_level,0) water_level, 1 relay1, a.created_dt, a.hours 
                                    
                                    FROM (SELECT a.tools_id,a.vibration vibration_problem, a.created_dt, a.hours, IFNULL(b.vibration,0) vibration_normal FROM
                                    (
                                        select tools_id,count(vibration) vibration, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_vibration
                                        where status = 'problem'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 1
                                    ) a LEFT JOIN (
                                        select tools_id,count(vibration) vibration, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_vibration
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 1
                                    ) b ON a.tools_id = b.tools_id AND a.created_dt = b.created_dt AND a.hours = b.hours) a 
                                    LEFT JOIN (SELECT a.tools_id,a.water_flow water_flow_problem, a.created_dt, a.hours, IFNULL(b.water_flow,0) water_flow_normal FROM
                                    (
                                        select tools_id,count(water_flow) water_flow, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_water_flow
                                        where status = 'problem'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 1
                                    ) a LEFT JOIN (
                                        select tools_id,count(water_flow) water_flow, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_water_flow
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 1
                                    ) b ON a.tools_id = b.tools_id AND a.created_dt = b.created_dt AND a.hours = b.hours) b ON a.tools_id = b.tools_id AND a.created_dt = b.created_dt AND a.hours = b.hours
                                    LEFT JOIN (select tools_id,water_level,created_dt from tbl_water_level order by created_dt desc limit 1) c ON a.tools_id = c.tools_id 
                                    #JOIN (select tools_id,relay,created_dt from tbl_relay order by created_dt desc limit 1) d ON a.tools_id = d.tools_id");
			} else if ($action == "last") {
				$query = $callConn->query("SELECT * FROM tools_detail a JOIN tools b ON a.tools_id = b.id ORDER BY b.id, a.created_dt DESC");
			} else if ($action == "last_top") {
				//$query = $callConn->query("SELECT a.tools_id, IFNULL(a.vibration,0) vibration, IFNULL(a.water_flow,0) water_flow, IFNULL(a.water_level,0) water_level, IFNULL(a.relay,0) relay1, IFNULL(MAX(a.created_dt),'2019-01-01') created_dt, IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 4, 2), 0) minutes, IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) hours, SUBTIME(RIGHT(a.created_dt, 8), CURDATE()) FROM tools_detail a JOIN tools b ON a.tools_id = b.id ORDER BY b.id, a.created_dt DESC LIMIT 1");
			    //$query = $callConn->query("SELECT a.tools_id, IFNULL(a.vibration,0) vibration, IFNULL(b.water_flow,0) water_flow, IFNULL(c.water_level,0) water_level, IFNULL(d.relay,0) relay1, IFNULL(MAX(a.created_dt),'2019-01-01') created_dt, IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 4, 2), 0) minutes, IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) hours, SUBTIME(RIGHT(a.created_dt, 8), CURDATE()) FROM (select tools_id,vibration,created_dt from tbl_vibration order by created_dt desc limit 1) a JOIN (select tools_id,water_flow,created_dt from tbl_water_flow order by created_dt desc limit 1) b ON a.tools_id = b.tools_id JOIN (select tools_id,water_level,created_dt from tbl_water_level order by created_dt desc limit 1) c ON a.tools_id = c.tools_id JOIN (select tools_id,relay,created_dt from tbl_relay order by created_dt desc limit 1) d ON a.tools_id = d.tools_id");
			    $query = $callConn->query("SELECT a.tools_id, IFNULL(a.vibration,0) vibration, IFNULL(b.water_flow,0) water_flow, IFNULL(c.water_level,0) water_level, IFNULL(d.relay,0) relay1, IFNULL(MAX(c.created_dt),'2019-01-01') created_dt, IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 4, 2), 0) minutes, IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 1, 2),0) hours, SUBTIME(RIGHT(c.created_dt, 8), CURDATE()) 
                                        FROM (select tools_id,count(vibration) vibration, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours from tbl_vibration group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) order by created_dt desc limit 1) a 
                                        JOIN (select tools_id,water_flow,created_dt from tbl_water_flow order by created_dt desc limit 1) b ON a.tools_id = b.tools_id 
                                        JOIN (select tools_id,water_level,created_dt from tbl_water_level order by created_dt desc limit 1) c ON a.tools_id = c.tools_id 
                                        JOIN (select tools_id,relay,created_dt from tbl_relay order by created_dt desc limit 1) d ON a.tools_id = d.tools_id");
			    
			} else if ($action == "hour") {
				#$query = $callConn->query("SELECT IFNULL(a.vibration,0) vibration, IFNULL(a.water_flow,0) water_flow, IFNULL(a.water_level,0) water_level, IFNULL(a.relay,0) relay1, IFNULL(a.created_dt,'2019-01-01') created_dt, a.hours FROM (SELECT DISTINCT tools_id, IFNULL(AVG(vibration),0) vibration, IFNULL(AVG(water_flow),0) water_flow, IFNULL(AVG(water_level),0) water_level, IFNULL(AVG(relay),0) relay,SUBSTRING(created_dt, 12, 2) hours, status, MAX(created_dt) created_dt FROM tools_detail WHERE status = 'normal' and LEFT(CURDATE(), 10) = LEFT(created_dt, 10) GROUP BY hours) a JOIN tools b ON a.tools_id = b.id WHERE LEFT(CURDATE(), 10) = LEFT(a.created_dt, 10) and a.status = 'normal' LIMIT 5");
			    $query = $callConn->query("SELECT a.tools_id, IFNULL(a.vibration,0) vibration, IFNULL(b.water_flow,0) water_flow, IFNULL(c.water_level,0) water_level, IFNULL(d.relay1,0) relay1, IFNULL(MAX(c.created_dt),'2019-01-01') created_dt, IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 4, 2), 0) minutes, IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 1, 2),0) hours, SUBTIME(RIGHT(c.created_dt, 8), CURDATE()) 
                                        FROM (select tools_id,count(vibration) vibration, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_vibration 
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) a 
                                        JOIN (select tools_id,cast(avg(water_flow) as decimal(6,2)) water_flow, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_water_flow 
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) b ON a.tools_id = b.tools_id and left(a.created_dt,10) = left(b.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(b.created_dt, 8), CURDATE()), 1, 2),0)
                                        JOIN (select tools_id,count(water_level) water_level, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_water_level 
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) c ON a.tools_id = c.tools_id and left(a.created_dt,10) = left(c.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 1, 2),0)
                                        LEFT JOIN (select tools_id,count(relay) relay1, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_relay
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) d ON a.tools_id = d.tools_id and left(a.created_dt,10) = left(d.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(d.created_dt, 8), CURDATE()), 1, 2),0)");
			    
			} else if ($action == "weeks") {
				$query = $callConn->query("SELECT tools_id, IFNULL(AVG(vibration),0) vibration, IFNULL(AVG(water_flow),0) water_flow, IFNULL(AVG(water_level),0) water_level, IFNULL(AVG(relay),0) relay1, LEFT(a.created_dt, 10) created_dt, EXTRACT(WEEK FROM LEFT(CURDATE(), 10)) weeks, EXTRACT(DAY FROM LEFT(a.created_dt, 10)) days, EXTRACT(MONTH FROM LEFT(a.created_dt, 10)) months, EXTRACT(YEAR FROM LEFT(a.created_dt, 10)) years FROM tools_detail a JOIN tools b ON a.tools_id = b.id WHERE DATE(a.created_dt) BETWEEN DATE_SUB(LEFT(CURDATE(), 10), INTERVAL 7 DAY) AND LEFT(CURDATE(), 10) AND status = 'normal' GROUP BY LEFT(a.created_dt, 10), tools_id ORDER BY LEFT(a.created_dt, 10) ASC LIMIT 7");
			} else if ($action == "months") {
				$query = $callConn->query("SELECT tools_id, IFNULL(AVG(vibration),0) vibration, IFNULL(AVG(water_flow),0) water_flow, IFNULL(AVG(water_level),0) water_level, IFNULL(AVG(relay),0) relay1, LEFT(a.created_dt, 7) created_dt, EXTRACT(MONTH FROM LEFT(a.created_dt, 10)) months, EXTRACT(YEAR FROM LEFT(a.created_dt, 10)) years FROM tools_detail a JOIN tools b ON a.tools_id = b.id WHERE DATE(a.created_dt) BETWEEN DATE_SUB(LEFT(CURDATE(), 10), INTERVAL 12 MONTH) AND LEFT(CURDATE(), 10) AND status = 'normal' GROUP BY LEFT(a.created_dt, 7), tools_id ORDER BY LEFT(a.created_dt, 7) ASC");
			}  else if ($action == "hour_problem") {
				$query = $callConn->query("SELECT IFNULL(a.vibration,0) vibration, IFNULL(a.water_flow,0) water_flow, IFNULL(a.water_level,0) water_level, IFNULL(a.relay,0) relay1, IFNULL(a.created_dt,'2019-01-01') created_dt, a.hours FROM (SELECT DISTINCT tools_id, IFNULL(AVG(vibration),0) vibration, IFNULL(AVG(water_flow),0) water_flow, IFNULL(AVG(water_level),0) water_level, IFNULL(AVG(relay),0) relay,SUBSTRING(created_dt, 12, 2) hours, status, MAX(created_dt) created_dt FROM tools_detail WHERE status = 'problem' and LEFT(CURDATE(), 10) = LEFT(created_dt, 10) GROUP BY hours) a JOIN tools b ON a.tools_id = b.id WHERE LEFT(CURDATE(), 10) = LEFT(a.created_dt, 10) and a.status = 'problem' LIMIT 5");
			} else if ($action == "weeks_problem") {
				$query = $callConn->query("SELECT tools_id, IFNULL(AVG(vibration),0) vibration, IFNULL(AVG(water_flow),0) water_flow, IFNULL(AVG(water_level),0) water_level, IFNULL(AVG(relay),0) relay1, LEFT(a.created_dt, 10) created_dt, EXTRACT(WEEK FROM LEFT(CURDATE(), 10)) weeks, EXTRACT(DAY FROM LEFT(a.created_dt, 10)) days, EXTRACT(MONTH FROM LEFT(a.created_dt, 10)) months, EXTRACT(YEAR FROM LEFT(a.created_dt, 10)) years FROM tools_detail a JOIN tools b ON a.tools_id = b.id WHERE DATE(a.created_dt) BETWEEN DATE_SUB(LEFT(CURDATE(), 10), INTERVAL 7 DAY) AND LEFT(CURDATE(), 10) AND status = 'problem' GROUP BY LEFT(a.created_dt, 10), tools_id ORDER BY LEFT(a.created_dt, 10) ASC LIMIT 7");
			} else if ($action == "months_problem") {
				$query = $callConn->query("SELECT tools_id, IFNULL(AVG(vibration),0) vibration, IFNULL(AVG(water_flow),0) water_flow, IFNULL(AVG(water_level),0) water_level, IFNULL(AVG(relay),0) relay1, LEFT(a.created_dt, 7) created_dt, EXTRACT(MONTH FROM LEFT(a.created_dt, 10)) months, EXTRACT(YEAR FROM LEFT(a.created_dt, 10)) years FROM tools_detail a JOIN tools b ON a.tools_id = b.id WHERE DATE(a.created_dt) BETWEEN DATE_SUB(LEFT(CURDATE(), 10), INTERVAL 12 MONTH) AND LEFT(CURDATE(), 10) AND status = 'problem' GROUP BY LEFT(a.created_dt, 7), tools_id ORDER BY LEFT(a.created_dt, 7) ASC");
			}else if ($action == "normal") {
				//$query = $callConn->query("SELECT a.tools_id, a.vibration, a.water_flow, a.water_level, a.relay, a.created_dt, b.name, b.lat, b.lng, b.description FROM tools_detail a JOIN tools b ON a.tools_id = b.id WHERE LEFT(CURDATE(), 10) = LEFT(a.created_dt, 10) and status = 'normal' ORDER BY b.id");
			
			    $query = $callConn->query("SELECT a.tools_id, e.name, IFNULL(a.vibration,0) vibration, IFNULL(b.water_flow,0) water_flow, IFNULL(c.water_level,0) water_level, IFNULL(d.relay1,0) relay1, IFNULL(MAX(c.created_dt),'2019-01-01') created_dt, IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 4, 2), 0) minutes, IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 1, 2),0) hours, SUBTIME(RIGHT(c.created_dt, 8), CURDATE()) 
                                        FROM (select tools_id,count(vibration) vibration, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_vibration 
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) a 
                                        JOIN (select tools_id,cast(avg(water_flow) as decimal(6,2)) water_flow, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_water_flow 
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) b ON a.tools_id = b.tools_id and left(a.created_dt,10) = left(b.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(b.created_dt, 8), CURDATE()), 1, 2),0)
                                        JOIN (select tools_id,count(water_level) water_level, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_water_level 
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) c ON a.tools_id = c.tools_id and left(a.created_dt,10) = left(c.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 1, 2),0)
                                        LEFT JOIN (select tools_id,count(relay) relay1, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_relay
                                        where status = 'normal'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) d ON a.tools_id = d.tools_id and left(a.created_dt,10) = left(d.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(d.created_dt, 8), CURDATE()), 1, 2),0)
                                        JOIN tools e ON a.tools_id = e.id");
			} else if ($action == "problem") {
				//$query = $callConn->query("SELECT a.tools_id, a.vibration, a.water_flow, a.water_level, a.relay, a.created_dt, b.name, b.lat, b.lng, b.description FROM tools_detail a JOIN tools b ON a.tools_id = b.id WHERE LEFT(CURDATE(), 10) = LEFT(a.created_dt, 10) and status = 'problem' ORDER BY b.id");
			
			    $query = $callConn->query("SELECT a.tools_id,e.name, IFNULL(a.vibration,0) vibration, IFNULL(b.water_flow,0) water_flow, IFNULL(c.water_level,0) water_level, IFNULL(d.relay1,0) relay1, IFNULL(MAX(c.created_dt),'2019-01-01') created_dt, IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 4, 2), 0) minutes, IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 1, 2),0) hours, SUBTIME(RIGHT(c.created_dt, 8), CURDATE()) 
                                        FROM (select tools_id,count(vibration) vibration, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_vibration 
                                        where status = 'problem'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) a 
                                        JOIN (select tools_id,cast(avg(water_flow) as decimal(6,2)) water_flow, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_water_flow 
                                        where status = 'problem'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) b ON a.tools_id = b.tools_id and left(a.created_dt,10) = left(b.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(b.created_dt, 8), CURDATE()), 1, 2),0)
                                        JOIN (select tools_id,count(water_level) water_level, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_water_level 
                                        where status = 'problem'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) c ON a.tools_id = c.tools_id and left(a.created_dt,10) = left(c.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 1, 2),0)
                                        LEFT JOIN (select tools_id,count(relay) relay1, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours 
                                        from tbl_relay
                                        where status = 'problem'
                                        group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0) 
                                        order by created_dt desc limit 5) d ON a.tools_id = d.tools_id and left(a.created_dt,10) = left(d.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(d.created_dt, 8), CURDATE()), 1, 2),0)
                                        JOIN tools e ON a.tools_id = e.id");
			}

			if ($query) {
				//echo "<script>alert('GET DATA')</script>";
			} else {
				echo "<script>alert('FAILED')</script>";
			}

			return $query;
		}
		
		public function storeProcedure()
		{
		    $callConn = $this->connectionKey();

			$query = $callConn->query("SELECT vibration,count(vibration) FROM (select vibration,id from tbl_vibration #WHERE LEFT(CURDATE(), 10) = LEFT(created_dt, 10) ORDER BY id DESC LIMIT 20) a GROUP BY vibration");
		}
		
		public function selReport($fromDt,$toDt,$status)
		{
		    $callConn = $this->connectionKey();

			$query = $callConn->query("SELECT a.tools_id, e.name, IFNULL(a.vibration,0) vibration, IFNULL(b.water_flow,0) water_flow, IFNULL(c.water_level,0) water_level, '1' relay1, IFNULL(a.created_dt,'2019-01-01') created_dt, a.hours,a.status
                                	FROM (select tools_id,count(vibration) vibration, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours,status from tbl_vibration where left(created_dt,10) between '$fromDt' and '$toDt' and status like '$status%' group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0),status order by created_dt desc) a 
                                    JOIN (select tools_id,count(water_flow) water_flow, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours,status from tbl_water_flow where left(created_dt,10) between '$fromDt' and '$toDt' and status like '$status%' group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0),status order by created_dt desc) b ON a.tools_id = b.tools_id and left(a.created_dt,10) = left(b.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(b.created_dt, 8), CURDATE()), 1, 2),0) and a.status = b.status 
                                    JOIN (select tools_id,count(water_level) water_level, left(created_dt,10) created_dt, IFNULL(SUBSTRING(RIGHT(created_dt, 8), 1, 2),0) hours,status from tbl_water_level where left(created_dt,10) between '$fromDt' and '$toDt' and status like '$status%' group by tools_id, left(created_dt,10), IFNULL(SUBSTRING(SUBTIME(RIGHT(created_dt, 8), CURDATE()), 1, 2),0),status  order by created_dt desc) c ON a.tools_id = c.tools_id and left(a.created_dt,10) = left(c.created_dt,10) and IFNULL(SUBSTRING(SUBTIME(RIGHT(a.created_dt, 8), CURDATE()), 1, 2),0) = IFNULL(SUBSTRING(SUBTIME(RIGHT(c.created_dt, 8), CURDATE()), 1, 2),0) and a.status = c.status
                                    #JOIN (select tools_id,relay,created_dt from tbl_relay where left(created_dt,10) between '$fromDt' and '$toDt' and status like '$status%' order by created_dt desc) d ON a.tools_id = d.tools_id
                                    JOIN tools e ON a.tools_id = e.id
                                    GROUP BY a.tools_id,e.name,a.created_dt,a.hours,a.status
                                    ORDER BY a.created_dt desc, a.hours desc, a.status");

			if ($query) {
				//echo "<script>alert('GET DATA')</script>";
			} else {
				echo "<script>alert('FAILED')</script>";
			}

			return $query;
		}
		
		public function addVibration($tool, $vibration, $date, $status)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("INSERT INTO tbl_vibration SET tools_id = '$tool', vibration = '$vibration', created_dt = '$date', status = '$status'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}
		
		public function addWaterFlow($tool, $water_flow, $date, $status)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("INSERT INTO tbl_water_flow SET tools_id = '$tool', water_flow = '$water_flow', created_dt = '$date', status = '$status'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}
		
		public function addWaterLevel($tool, $water_level, $date, $status)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("INSERT INTO tbl_water_level SET tools_id = '$tool', water_level = '$water_level', created_dt = '$date', status = '$status'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}
		
		public function addRelay($tool, $relay, $date, $status)
		{
			$callConn = $this->connectionKey();

			$query = $callConn->query("INSERT INTO tbl_relay SET tools_id = '$tool', relay = '$relay', created_dt = '$date', status = '$status'");

			if ($query) {
				//echo "<script>alert('Data Sudah Masuk')</script>";
			} else {
				echo "<script>alert('Data Tidak Masuk')</script>";
			}

			return $query;

		}

	}
	   
?>