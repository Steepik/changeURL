<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set("Europe/Kiev");
    }

    public function index()
    {
        return view('index');
    }

    /**
     * Add new url to our DB
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Laravel\Lumen\Http\Redirector
     */
    public function store(Request $request)
    {
        if(empty($request->input('url')))
        {
            return redirect('/');
        }
        else
        {
            $url_original = $request->input('url');
            $url_changed = strtolower(str_random(16));
            $password = $request->input('password');
            $created_at = date('Y-m-d H:i:s');
            $hours = $request->input('endtimehour');
            $endtime = $request->input('endtime') .' '.$hours;

            //Hash password
            if(!empty($password))
            {
                $hashedpassword = trim(Hash::make($password));
            }
            else
            {
                $hashedpassword = '';
            }

            $result = app('db')->insert('INSERT INTO urls(url_original, url_changed, password, endtime, created_at) VALUES(?, ?, ?, ?, ?)',
                [$url_original, $url_changed, $hashedpassword, $endtime, $created_at]);

            //Show url's info
            if($result)
            {
                $data['url_original'] = $url_original;
                $data['url_changed'] = url().'/url/'.$url_changed;
                $data['password'] = $password;

                return view('created_url', $data);
            }
        }
    }

    /**
     * Get our URL without password
     *
     * @param $url
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Laravel\Lumen\Http\Redirector
     */
    public function getUrl($url)
    {
        //Check time to delete url from db
        $nowDate = date('Y-m-d H:i:s');

        app('db')->delete('DELETE FROM urls WHERE endtime <= ? AND url_changed = ?', [$nowDate, $url]);

        $result = app('db')->select('SELECT url_original, url_changed, password FROM urls WHERE url_changed = ? LIMIT 1', [$url]);

        if(count($result) > 0) {
            if ( ! $result[0]->password)
            {
                if (starts_with($result[0]->url_original, 'http://')) {
                    return redirect($result[0]->url_original);
                } else {
                    return redirect('http://' . $result[0]->url_original);
                }
            }
            else
            {
                $data['url_changed'] = $result[0]->url_changed;

                return view('url_pass', $data);
            }
        }
        else
        {
            abort(404);
        }
    }

    /**
     * Check URL's password if passwords match do redirect
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Laravel\Lumen\Http\Redirector
     */
    public function checkUrlPass(Request $request)
    {
        $url_changed = $request->input('url_changed');
        $password = $request->input('password');

        //Check time to delete url from db
        $nowDate = date('Y-m-d H:i:s');

        app('db')->delete('DELETE FROM urls WHERE endtime <= ? AND url_changed = ?', [$nowDate, $url_changed]);

        $result = app('db')->select('SELECT url_original, url_changed, password FROM urls WHERE url_changed = ? LIMIT 1', [$url_changed]);

        if(count($result) > 0)
        {
            //Check passwords
            if(Hash::check($password, $result[0]->password))
            {
                if (starts_with($result[0]->url_original, 'http://')) {
                    return redirect($result[0]->url_original);
                } else {
                    return redirect('http://' . $result[0]->url_original);
                }
            }
            else
            {
                $errors = ['Wrong password'];
                return view('errors.show_errors', compact('errors'));
            }
        }
        else
        {
            abort(404);
        }

    }
}
