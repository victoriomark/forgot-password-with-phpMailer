<?phpnamespace model;use config\connection;use Exception;require_once '../../config/connection.php';class forgot_password extends connection{    public function __construct()    {       parent::__construct();    }  public static function checkIfEmailIsExist($email):bool  {      $db = new connection();      $conn = $db->Connect();      try {          $query = "SELECT * FROM users WHERE email = ?";          $stmt = $conn->prepare($query);          if (!$stmt){              echo json_encode(['success' => false, 'message' => 'Failed to prepared statement']);          }          $stmt->bind_param('s',$email);          $stmt->execute();          $result = $stmt->get_result();          if ($result->num_rows > 0){              return true;          }else{              return false;          }      }catch (Exception $e){          error_log('Error',$e->getMessage());          return false;      }  }  public static function storeOTP($otp,$email):bool  {      $db = new connection();      $conn = $db->Connect();      try {          $query = "UPDATE users SET code = ? WHERE email = ?";          $stmt = $conn->prepare($query);          if (!$stmt){              echo json_encode(['success' => false, 'message' => 'Failed to prepared statement']);              return false;          }          $stmt->bind_param('ss',$otp,$email);          if ($stmt->execute()){             return true;          }else{              return false;          }      }catch (Exception $e){          error_log('Error',$e->getMessage());          return false;      }  }  public static function verifyOPT($otp,$email):bool  {      $db = new connection();      $conn = $db->Connect();      try {          $query = "SELECT * FROM users WHERE code = ? AND email = ?";          $stmt = $conn->prepare($query);          if (!$stmt){              echo json_encode(['success' => false, 'message' => 'Failed to prepared statement']);              return false;          }          $stmt->bind_param('ss',$otp,$email);          $stmt->execute();          $result = $stmt->get_result();          if ($result->num_rows > 0){              return true;          }else{              return false;          }      }catch (Exception $e){          error_log('Error',$e->getMessage());          return false;      }  }}