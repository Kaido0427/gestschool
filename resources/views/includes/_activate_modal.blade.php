<div>
    <div id="modal_desactive_user" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog danger">
            <div class="modal-content">
                <form id="user_desactive_form" action="" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-header bg-danger-800">
                        <h6 class="modal-title">Désactivé un Compte</h6>
                    </div>

                    <div class="modal-body">
                        <h4 class="font-weight-semibold"><i class="icon-alert"></i> ATTENTION!</h4>
                        <p>Confirmé la désactivation de : <span class="user_name"></span></p>
                        <hr>
                        <p>Appuyez sur le bouton <span class="text-info-800 font-weight-bold">Continuer</span> si vous
                            êtes sûr
                            de ce que vous faites!</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn bg-danger-800 legitRipple">Continuer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_active_user" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog danger">
            <div class="modal-content">
                <form id="user_active_form" action="" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-header bg-danger-800">
                        <h6 class="modal-title">Activé un Compte</h6>
                    </div>

                    <div class="modal-body">
                        <h4 class="font-weight-semibold"><i class="icon-alert"></i> ATTENTION!</h4>
                        <p>Confirmé l'activation de : <span class="user_name"></span></p>
                        <hr>
                        <p>Appuyez sur le bouton <span class="text-info-800 font-weight-bold">Continuer</span> si vous
                            êtes sûr
                            de ce que vous faites!</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn bg-danger-800 legitRipple">Continuer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_init_password" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog danger">
            <div class="modal-content">
                <form id="init_password_form" action="" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-header bg-danger-800">
                        <h6 class="modal-title">Initialisation de mot de passe</h6>
                    </div>

                    <div class="modal-body">
                        <h4 class="font-weight-semibold"><i class="icon-alert"></i> ATTENTION!</h4>
                        <p>Confirmé l'initialisation du mot de passe de : <span class="user_name"></span></p>
                        <hr>
                        <p>Appuyez sur le bouton <span class="text-info-800 font-weight-bold">Continuer</span> si vous
                            êtes sûr
                            de ce que vous faites!</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn bg-danger-800 legitRipple">Continuer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal_delete_information" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog danger">
            <div class="modal-content">
                <form id="delete_information_form" action="" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-header bg-danger-800">
                        <h6 class="modal-title">SUPPRESSION D'INFORMATION</h6>
                    </div>

                    <div class="modal-body">
                        <h4 class="font-weight-semibold"><i class="icon-alert"></i> ATTENTION!</h4>
                        <p>Confirmé la suppression de l'ionformation </p>
                        <hr>
                        <p>Appuyez sur le bouton <span class="text-info-800 font-weight-bold">Continuer</span> si vous
                            êtes sûr
                            de ce que vous faites!</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn bg-danger-800 legitRipple">Continuer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="student_pass" class="modal fade " tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog danger">
            <div class="modal-content">
                <form id="student_pass_form" action="" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-header bg-success">
                        <h6 class="modal-title">Passe en classe superieur</h6>
                    </div>

                    <div class="modal-body">
                        <h4 class="font-weight-semibold"><i class="icon-alert"></i> ATTENTION!</h4>
                        <p>Confirmé le passage en classe supérieur de : <span class="user_name"></span></p> </p>
                        <hr>
                        <p>Appuyez sur le bouton <span class="text-info-800 font-weight-bold">Continuer</span> Pour
                            valider
                            votre choix !</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn bg-danger-800 legitRipple">Continuer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="student_fail" class="modal fade " tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog danger">
            <div class="modal-content">
                <form id="student_fail_form" action="" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-header bg-danger">
                        <h6 class="modal-title">Reprise de la classe</h6>
                    </div>

                    <div class="modal-body">
                        <h4 class="font-weight-semibold"><i class="icon-alert"></i> ATTENTION!</h4>
                        <p>Confirmé la reprise  de la classe pour : <span class="user_name"></span></p> </p>
                        <hr>
                        <p>Appuyez sur le bouton <span class="text-info-800 font-weight-bold">Continuer</span> Pour
                            valider
                            votre choix !</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn bg-danger-800 legitRipple">Continuer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="delete_matiere_in_class" class="modal fade " tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog danger">
            <div class="modal-content">
                <form id="delete_matiere_in_class_form" action="" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-header bg-success">
                        <h6 class="modal-title">Confirmé la suppression de la matiere de la classe</h6>
                    </div>

                    <div class="modal-body">
                        <h4 class="font-weight-semibold"><i class="icon-alert"></i> ATTENTION!</h4>
                        <hr>
                        <p>Appuyez sur le bouton <span class="text-info-800 font-weight-bold">Continuer</span> Pour
                            valider
                            votre choix !</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn bg-danger-800 legitRipple">Continuer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="delete_ue" class="modal fade " tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog danger">
            <div class="modal-content">
                <form id="delete_ue_form" action="" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-header bg-success">
                        <h6 class="modal-title">Confirmé la suppression de l'ue</h6>
                    </div>

                    <div class="modal-body">
                        <h4 class="font-weight-semibold"><i class="icon-alert"></i> ATTENTION!</h4>
                        <hr>
                        <p>Appuyez sur le bouton <span class="text-info-800 font-weight-bold">Continuer</span> Pour
                            valider
                            votre choix !</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn bg-danger-800 legitRipple">Continuer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
