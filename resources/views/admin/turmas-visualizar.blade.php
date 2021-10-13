<div class="turma">
    <div class="turma_menu">
        <i class="material-icons click t-menu active" data-menu="1" title="informações atuais turma">dashboard</i>
        <i class="material-icons click t-menu" data-menu="2" title="aulas atuais e frêquencia">assignment_turned_in</i>
        <!-- <i class="material-icons click t-menu" data-menu="3" title="lista de frequência">format_list_numbered</i> -->
    
    </div>
    <div class="turma_perfil">
        <h3 id="v_turma_id" data-id="{{ $turma->turma_id }}" class="turma_titulo">{{ $turma->turma_nome }}</h3>
        <p>
            <sup>Situação:
            @if($turma->turma_status == 1)
                <b>Em formação</b>
            @elseif($turma->turma_status == 2)
                <b>Vigente</b>
            @elseif($turma->turma_status == 3)
                <b>Finalizada</b>
            @else
                <b>Desativada</b>
            @endif
            </sup>
        </p>
    </div>
    <div data-menu="1" class="t-container active turma_dashboard">
        <div class="turma_infos">
            <div class="turma_info box">
                <h6><i class="material-icons">school</i> Professor</h6>
                <b>{{ $turma->professor->name }}</b>
            </div>
            <div class="turma_info box">
                <h6><i class="material-icons">import_contacts</i> Curso</h6>
                <b>{{ $turma->curso->curso_nome }}</b>
            </div>
            <div class="turma_info box">
                <h6><i class="material-icons">map</i> Unidade</h6>
                <b>{{ $turma->unidade->unidade_nome }}</b>
            </div>
            <div class="turma_info box">
                <h6><i class="material-icons">alarm</i>Horário</h6>
                <b>{{ $turma->turma_horario }}</b>
            </div>
            <div class="turma_info box">
                <h6><i class="material-icons">perm_identity</i>Alunos Ativos</h6>
                <b>{{$turma->alunos->count()}}</b>
            </div>
            <div class="turma_info box">
                <h6><i class="material-icons">import_contacts</i>Modulo Atual</h6>
                <b>{{ $turma->modulo->modulo_nome }}</b>
            </div>
            
            
        </div>
        <div class="turma_proxima_aula box">
            <h6>Próxima aula</h6>
            @if($turma->aula_id != '' && $turma->aula_id != 9999)
                <h6>Aula{{ $turma->aula->aula_ordem }} - {{ $turma->aula->aula_nome }}</h6>
                <p>{{ $turma->aula->aula_descricao }}</p>
            @elseif($turma->aula_id == 9999)
                <h6>Curso concluído</h6>
                <p>Todas as aulas foram concluídas</p>
            @else
                @if($turma->modulo_id != '')
                    <h6>Aula{{ $turma->modulo->aula[0]->aula_ordem }} - {{ $turma->modulo->aula[0]->aula_nome }}</h6>
                    <p>{{ $turma->modulo->aula[0]->aula_descricao }}</p>
                @else
                    <h6>Aula {{ $turma->curso->uas[0]->modulo[0]->aula[0]->aula_ordem }} - {{ $turma->curso->uas[0]->modulo[0]->aula[0]->aula_nome }}</h6>
                    <p>{{ $turma->curso->uas[0]->modulo[0]->aula[0]->aula_descricao }}</p>
                @endif
            @endif
            @if($turma->aula_id != 9999)
                <button class="click suave t-menu" data-menu="2">Iniciar aula</button>
            @endif
            <div class="clear"></div>
        </div>
    </div>
    <div data-menu="2" class="t-container">
        <h3 class="barlow">Aulas</h3>
        <div class="turma_aulas">
            @foreach($turma->curso->uas as $ua)
                @foreach($ua->modulo as $modulo)
                    <div class="modulo">
                        <h3 class="barlow">{{ $ua->ua_nome }} - {{ $modulo->modulo_nome }}</h3>
                        @foreach($modulo->aula as $aula)
                            <div class="aula box @if($aula->aula_id == $turma->aula_id) active @endif" data-id="{{ $aula->aula_id }}">
                                <div class="aula_ordem">Aula {{ $aula->aula_ordem }}</div>
                                <div class="aula_nome">{{ $aula->aula_nome }}</div>
                                <div class="aula_acoes">    
                                    @if($aula->aula_id < $turma->aula_id)
                                        <i class="material-icons" title="Aula finalizada">check_circle</i>
                                    @else
                                        <i class="material-icons" title="Aguardando">radio_button_unchecked</i>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="clear"></div>
                @endforeach
            @endforeach
        </div>
        @if($turma->aula_id != 9999)
        <div class="aula_atual">
            <h3 class="barlow">Aula atual</h3>
            <div class="box">
                    <div class="aula_ordem">Aula {{ $turma->aula->aula_ordem }}</div>    
                    <div class="aula_nome">{{ $turma->aula->aula_nome }}</div>
                    <div class="aula_descricao">{{ $turma->aula->aula_descricao }}</div>
                    <div class="aula_nome">Lista de frequência:</div>
                    <form id="form-frequencia-turma" method="post">
                        <input type="hidden" name="aula_id" value="{{ $turma->aula->aula_id }}">
                        <input type="hidden" name="turma_id" value="{{ $turma->turma_id }}">
                        <ul class="list-frequencia">
                            @foreach($alunos as $aluno)
                                <li>
                                    {{$aluno->alunos->name}}
                                    <div class="checkbox">
                                        <input type="checkbox" value="{{$aluno->alunos->id}}">
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <textarea name="turma_aula_observacao"></textarea>
                        <div class="clear"></div>
                        <button type="submit" class="suave click">Finalizar aula</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
</div>
<div data-menu="3" class="t-container">
            <h3 class="barlow">Frequencia</h3>
            <table id="tFrequencia" style="padding-top: 16px;" class="stripe">
                <thead>
                    <tr>
                        <td class="mini-title upper">#</td>
                        <td class="mini-title upper">Matricula</td>
                        <td class="mini-title upper">Nome</td>
                        <td class="mini-title upper">Nota</td>
                        <td class="mini-title upper">Modulo</td>
                        <td class="mini-title upper">Qual Avaliação?</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
<div class="clear"></div>

<script>
$(document).ready( function () {
        $('#tFrequencia',).DataTable();
    });
</script>