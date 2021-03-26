<?php

// connect to main db
$this->db = new \xframe\Database\App();
$this->conn = $this->db->connect(array(

    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'xframe',
    'charset' => 'utf8mb4'

));

$loggedIn = false;
$this->global['loggedIn'] = $loggedIn;

// fletch login
if (isset($_COOKIE[$this->config['prefix'] . 'authKey1']))
    if (isset($_COOKIE[$this->config['prefix'] . 'authKey2']))
        if (isset($_COOKIE[$this->config['prefix'] . 'authKey3'])) {

            // process keys
            $this->db->select()
                ->table('xe_users')
                ->column('*')
                ->where('authKey1 = ? AND authKey2 = ? AND authKey3 = ?')
                ->param(array(

                    $_COOKIE[$this->config['prefix'] . 'authKey1'],
                    $_COOKIE[$this->config['prefix'] . 'authKey2'],
                    $_COOKIE[$this->config['prefix'] . 'authKey3']

                ))
                ->types("sss")
                ->execute($this->conn);

            while ($row = $this->db->fetch()) {

                if (isset($row['username']) && $row['mode'] == 'verified') {

                    $loggedIn = true;
                    $this->global['loggedIn'] = $loggedIn;

                    // define account details
                    $this->global['user_username'] = $row['username'];
                    $this->global['user_endActionAuth'] = $row['endActionAuth'];
                    $this->global['user_avatar'] = $row['avatar'];

                    foreach ($row as $row_key => $row_data) {

                        $this->global['user_' . $row_key] = $row_data;
                    }

                    return false;
                } else {

                    $loggedIn = false;
                    $this->global['loggedIn'] = $loggedIn;
                    return false;
                }

                $this->global['loggedIn'] = false;
                return false;
            }

            $this->global['loggedIn'] = false;
            return false;
        }
