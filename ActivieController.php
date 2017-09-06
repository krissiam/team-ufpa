<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activie;
use Amranidev\Ajaxis\Ajaxis;
use URL;

use App\Subgrupo;

use Illuminate\Support\Facades\Input;


class ActivieController extends Controller
{
    public function index()
    {
        $title = 'Consultar Activies';
        $activies = Activie::paginate(6);
        return view('dashboard.activie.index',compact('activies','title'));
    }

///Consulta de  Activies de acordo com o grupo
    public function indexListening(){

        $title = 'Consultar Activies';
        $subgrupos = Subgrupo::where("grupo_id", 1)
            ->pluck('id');
        $activies = Activie::whereIn("subgrupo_id", $subgrupos)
            ->paginate(6);
        return view('dashboard.activie.listening.index',compact('activies','title'));
    }

    public function indexSpeaking(){

        $title = 'Consultar Activies';
        $subgrupos = Subgrupo::where("grupo_id", 2)
            ->pluck('id');
        $activies = Activie::whereIn("subgrupo_id", $subgrupos)
            ->paginate(6);
        return view('dashboard.activie.speaking.index',compact('activies','title'));
    }

    public function indexReading(){

        $title = 'Consultar Activies';
        $subgrupos = Subgrupo::where("grupo_id", 3)
            ->pluck('id');

        $activies = Activie::whereIn("subgrupo_id", $subgrupos)
            ->paginate(6);
        return view('dashboard.activie.reading.index',compact('activies','title'));

    }

    public function indexWriting() {

        $title = 'Consultar Activies';
        $subgrupos = Subgrupo::where("grupo_id", 4)
            ->pluck('id');
        $activies = Activie::whereIn("subgrupo_id", $subgrupos)
            ->paginate(6);
        return view('dashboard.activie.writing.index',compact('activies','title'));
    }



    public function create(){

        $title = 'Cadastrar Activies';
        
        $subgrupos = Subgrupo::all()->pluck('nome','id');
        
        return view('dashboard.activie.create',compact('title','subgrupos'  ));
    }


///Cadastro de  Activies de acordo com o grupo
    public function createListening(){

        $title = 'Cadastrar Listening';

        $subgrupos = Subgrupo::where("grupo_id", 1)
            ->pluck('nome','id');

        return view('dashboard.activie.listening.create',compact('title','subgrupos'  ));
    }

    public function createSpeaking(){

        $title = 'Cadastrar Speaking';

        $subgrupos = Subgrupo::where("grupo_id", 2)
            ->pluck('nome','id');

        return view('dashboard.activie.speaking.create',compact('title','subgrupos'  ));
    }

    public function createReading(){

        $title = 'Cadastrar Reading';

        $subgrupos = Subgrupo::where("grupo_id", 3)
            ->pluck('nome','id');

        return view('dashboard.activie.reading.create',compact('title','subgrupos'  ));
    }

    public function createWriting() {

        $title = 'Cadastrar Writing';

        $subgrupos = Subgrupo::where("grupo_id", 4)
            ->pluck('nome','id');

        return view('dashboard.activie.writing.create',compact('title','subgrupos'  ));
    }


    public function store(Request $request){
        $activie = new Activie();

        $activie->titulo = $request->titulo;

        $activie->descricao = $request->descricao;

        /**Upload do pdf */

        $pdf = Input::file('pdf');
        if ($pdf) {
            $extension = $pdf->getClientOriginalExtension();
            $fileName = 'pdf-'.rand(11111, 99999) . '.' . $extension; // renomeia o arquivo
            $destinationPathPdf = 'uploads';// pasta de destino

            $pdf->move($destinationPathPdf, $fileName);
            $activie->pdf = $fileName;
        }

        $activie->publicado = 1;
        
        $activie->data_cadastro =  date('Y-m-d');

        $activie->subgrupo_id = $request->subgrupo_id;

        $activie->save();


        return redirect('/dashboard/activie');
    }


    public function show($id,Request $request)
    {
        $title = 'Detallhes da Activie';

        if($request->ajax())
        {
            return URL::to('/dashboard/activie/'.$id);
        }

        $activie = Activie::findOrfail($id);
        return view('dashboard.activie.show',compact('title','activie'));
    }


    public function edit($id,Request $request)
    {
        $title = 'Editar Activie';
        if($request->ajax())
        {
            return URL::to('/dashboard/activie/'. $id . '/edit');
        }

        $activie = Activie::findOrfail($id);

        $subgrupo = Subgrupo::where('id', $activie->subgrupo_id)->pluck('grupo_id');
        $subgrupos = Subgrupo::where('grupo_id',$subgrupo)->pluck('nome','id','grupo_id');

        return view('dashboard.activie.edit',compact('title','activie' ,'subgrupos' ) );
    }


    public function update($id,Request $request)
    {
        $activie = Activie::findOrfail($id);
    	
        $activie->titulo = $request->titulo;
        
        $activie->descricao = $request->descricao;

        $pdf = Input::file('pdf');

        if ($pdf) {
            $extension = $pdf->getClientOriginalExtension();
            $fileName = 'pdf-'.rand(11111, 99999) . '.' . $extension; // renomeia o arquivo
            $destinationPathPdf = 'uploads'; // pasta de destino

            $pdf->move($destinationPathPdf, $fileName);
            $activie->pdf = $fileName;
        }

        $activie->subgrupo_id = $request->subgrupo_id;

        $activie->save();

        return redirect('/dashboard/activie'.$id);

        }


    public function DeleteMsg($id,Request $request)
    {
        $msg = Ajaxis::BtDeleting('Atenção!!','Você realmente deseja excluir esta Atividade?','/dashboard/activie/'. $id . '/delete');

        if($request->ajax())
        {
            return $msg;
        }
    }


    public function destroy($id)
    {
     	$activie = Activie::findOrfail($id);
     	$activie->delete();
        return URL::to('/dashboard');
    }

    public function disable($id, $local)
    {
        $activie = Activie::findOrfail($id);
        $activie->publicado = 0;
        $activie->save();
        return URL::to("dashboard/activie/$local/index");
    }

    public function enable($id, $local)
    {
        $activie = Activie::findOrfail($id);
        $activie->publicado = 1;
        $activie->save();
        return URL::to("dashboard/activie/$local/index");
    }
}
