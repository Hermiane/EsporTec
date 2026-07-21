<?php

namespace App\Http\Controllers;

use App\Models\AdminArena;
use App\Models\Arena;
use App\Models\BloqueioQuadra;
use App\Models\FuncionarioArena;
use App\Models\Reserva;
use App\Models\SuperAdmin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function dia(Request $request) { return $this->listar($request, now()->toDateString(), now()->toDateString()); }
    public function semana(Request $request) { return $this->listar($request, now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()); }
    public function alterarHorario(Request $request, $id)
    {
        $d=$request->validate(['data'=>['required','date','after_or_equal:today'],'hora_inicio'=>['required','date_format:H:i'],'hora_fim'=>['required','date_format:H:i','after:hora_inicio']]);
        $r=Reserva::with('quadra.horariosFuncionamento')->findOrFail($id); $user=$request->user();
        abort_unless($this->temAcesso($user->id,$r->quadra->arenas_id),403); abort_if($r->status==='cancelada',422,'Reserva cancelada não pode ser alterada.');
        $dia=$this->diaSemana(Carbon::parse($d['data']));
        $aberto=$r->quadra->horariosFuncionamento->where('dia_semana',$dia)->where('ativo',true)->contains(fn($h)=>$d['hora_inicio']>=substr($h->hora_inicio,0,5)&&$d['hora_fim']<=substr($h->hora_fim,0,5));
        abort_unless($aberto,422,'Horário fora do funcionamento da quadra.');
        $bloqueado=BloqueioQuadra::where('quadras_id',$r->quadras_id)->where('data',$d['data'])->where('hora_inicio','<',$d['hora_fim'])->where('hora_fim','>',$d['hora_inicio'])->exists();
        abort_if($bloqueado,409,'Horário bloqueado.');
        $conflito=Reserva::where('quadras_id',$r->quadras_id)->where('data',$d['data'])->where('id','!=',$r->id)->whereIn('status',['pendente','confirmada'])->where('hora_inicio','<',$d['hora_fim'])->where('hora_fim','>',$d['hora_inicio'])->exists();
        abort_if($conflito,409,'Horário indisponível.'); $r->update($d+['alteradas_por'=>$user->id]); return response()->json($r->fresh());
    }
    private function listar(Request $request,string $inicio,string $fim) { $id=$request->user()->id; return response()->json(Reserva::with(['usuario','quadra.arena'])->whereBetween('data',[$inicio,$fim])->whereHas('quadra',fn($q)=>$q->whereIn('arenas_id',$this->arenaIds($id)))->orderBy('data')->orderBy('hora_inicio')->get()); }
    private function arenaIds(int $id): array { if(SuperAdmin::where('usuarios_id',$id)->where('ativo',true)->exists()) return Arena::pluck('id')->all(); return array_values(array_unique(array_merge(AdminArena::where('usuarios_id',$id)->where('ativo',true)->pluck('arenas_id')->all(),FuncionarioArena::where('usuarios_id',$id)->where('ativo',true)->pluck('arenas_id')->all()))); }
    private function temAcesso(int $id,int $arena): bool { return in_array($arena,$this->arenaIds($id),true); }
    private function diaSemana(Carbon $d): string { return ['segunda-feira','terca-feira','quarta-feira','quinta-feira','sexta-feira','sabado','domingo'][$d->dayOfWeekIso-1]; }
}
