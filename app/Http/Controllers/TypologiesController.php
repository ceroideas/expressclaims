<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Typology;
use App\TypologySection;
use App\TypologySectionInput;
use App\TypologySectionInputOption;

class TypologiesController extends Controller
{
    //
    public function index($id = null)
    {   
        $typologies = Typology::all();
        $e_t = null;

        if ($id) {
            $e_t = Typology::find($id);
        }
        return view('admin.typologies.index', compact('typologies','e_t'));
    }
    public function index2($id)
    {   
        $t = Typology::find($id);
        $sections = TypologySection::where('typology_id',$id)->orderBy('order','desc')->get();

        return view('admin.typologies.sections', compact('t','sections'));
    }

    public function addTemplate($id)
    {
        return view('admin.typologies.input',['typology_section_id'=>$id]);
    }
    public function add(Request $r,$id = null) 
    {
        if ($id) {
            $t = Typology::find($id);
        }else{
            $t = new Typology;
        }
        $t->long_name = $r->long_name;
        $t->short_name = $r->short_name;
        $t->order = 0;
        $t->save();
    }

    public function addSection(Request $r)
    {
        $t = new TypologySection;
        $t->typology_id = $r->typology_id;
        $t->name = $r->name;
        $t->order = 0;
        $t->save();

        return back();
    }

    public function addInput(Request $r)
    {
        $this->validate($r,[
            'question'=>'required',
            // 'name'=>'required'
        ]);

        $t = new TypologySectionInput;
        $t->typology_section_id = $r->typology_section_id;
        $t->key = $r->key;
        $t->question = $r->question;
        $t->type = $r->type;
        $t->order = 0;
        $t->info = $r->info;
        $t->save();

        /**/

        if (isset($r->options)) {
            foreach ($r->options as $key => $value) {
                $io = new TypologySectionInputOption;
                $io->typology_section_input_id = $t->id;
                $io->option = $value;
                $io->save();
            }
        }
    }

    public function updateInput(Request $r)
    {
        $this->validate($r,[
            'question'=>'required',
            // 'name'=>'required'
        ]);

        $t = TypologySectionInput::find($r->id);
        if (isset($r->modify)) {
            $t->type = $r->type;
        }
        $t->key = $r->key;
        $t->question = $r->question;
        $t->info = $r->info;
        
        $t->save();

        if (isset($r->modify)) {

            TypologySectionInputOption::where('typology_section_input_id',$r->id)->delete();

            if (isset($r->options)) {
                foreach ($r->options as $key => $value) {
                    $io = new TypologySectionInputOption;
                    $io->typology_section_input_id = $t->id;
                    $io->option = $value;
                    $io->save();
                }
            }
        }
    }

    public function changeSectionOrder(Request $r)
    {
        if ($r->sections) {
            $a = count($r->sections);
            foreach ($r->sections as $key => $value) {
                $ph = TypologySection::find($value);
                $ph->order = $a;
                $ph->save();
                $a--;
            }
        }
    }

    public function changeInputOrder(Request $r)
    {
        if ($r->inputs) {
            $a = count($r->inputs);
            foreach ($r->inputs as $key => $value) {
                $inp = TypologySectionInput::find($value);
                $inp->order = $a;
                $inp->save();
                $a--;
            }
        }
    }

    public function updateSection(Request $r)
    {
        $s = TypologySection::find($r->id);
        $s->name = $r->name;
        $s->save();
    }

    public function deleteQuestion($id)
    {
        $i = TypologySectionInput::find($id);

        $o = TypologySectionInputOption::where('typology_section_input_id',$i->id)->delete();

        $i->delete();
    }

    public function deleteSection($id)
    {
        $s = TypologySection::find($id);
        $i = TypologySectionInput::where('typology_section_id',$s->id)->get();

        foreach ($i as $key => $value) {
            $o = TypologySectionInputOption::where('typology_section_input_id',$value->id)->delete();
            $value->delete();
        }
        $s->delete();
    }

    public function deleteTypology($id)
    {
        Typology::find($id)->delete();
        $s = TypologySection::where('typology_id',$id)->get();
        foreach ($s as $key => $value) {
            $this->deleteSection($value->id);
        }
    }
}
