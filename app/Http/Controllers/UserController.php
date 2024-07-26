<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        // dd("show");
        // exit;

        $users = User::get();

        return view('users.index', ['users' => $users]);
    }

    public function import(Request $request){
        // dd($request);
        // exit;

        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ],['file.required' => 'O arquivo é obligatorio.', 
            'file.mimes' => 'So pode enviar arquivos csv', 
            'file.max' => 'O tamanho do arquivo excede o permitido.'
        ]);
        
        $headers = ['name', 'email', 'password'];

        //Receber o arquivo
        $dataFormFile = file($request->file('file'));

        //Converter os dados em uma array
        $dataFile = array_map('str_getcsv', $dataFormFile);
        
        //Iterar os valores
        $totalReg = 0;
        $emailCadastrados = false;
        foreach ($dataFile as $keyData => $row) {
            $values = explode(';', $row[0]);

            foreach ($headers as $key => $header) {

                $arrayValues[$keyData][$header] = $values[$key];
              
                //Validar a repetição de email
                if($header == "email"){
                    if(User::where('email', $values[$key])->first()){
                        $emailCadastrados .= $values[$key]. ",";
                    }
                } 

                if($header == "password"){
                    $arrayValues[$keyData][$header] = Hash::make($arrayValues[$keyData]['password'], ['rounds' => 12]);
                }
                
                //$arrayValues[$keyData][$header] = $values[$key];
            }
            $totalReg +=1;
        }
       //dd($arrayValues);
       if($emailCadastrados){
        return back()->with('erro','Dados duplicados. <br>Total de registros: ' .$emailCadastrados);
       }
       User::insert($arrayValues);
       return back()->with('success','Dados importados com sucesso. <br>Total de registros: ' .$totalReg);
    }
}
