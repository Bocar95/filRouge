import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AcceuilComponent } from './acceuil/acceuil.component';
import { AuthGuard } from './service/authGuardService/auth.guard';
import { ConnexionComponent } from './connexion/connexion.component';
import { ProfilComponent } from './acceuil/admin/profil/profil.component';
import { DetailsProfilComponent } from './acceuil/admin/profil/details-profil/details-profil.component';
import { AdminUserComponent } from './acceuil/admin/admin-user/admin-user.component';
import { FormulaireAddAdminComponent } from './acceuil/admin/formulaires/adminFormulaires/formulaire-add-admin/formulaire-add-admin.component';
import { FormulairePutAdminComponent } from './acceuil/admin/formulaires/adminFormulaires/formulaire-put-admin/formulaire-put-admin.component';
import { ApprenantUserComponent } from './acceuil/admin/apprenant-user/apprenant-user.component';
import { FormulairePutApprenantComponent } from './acceuil/admin/formulaires/apprenantFormulaires/formulaire-put-apprenant/formulaire-put-apprenant.component';
import { FormulaireAddApprenantComponent } from './acceuil/admin/formulaires/apprenantFormulaires/formulaire-add-apprenant/formulaire-add-apprenant.component';
import { CmUserComponent } from './acceuil/admin/cm-user/cm-user.component';
import { FormulairePutCmComponent } from './acceuil/admin/formulaires/cmFormulaires/formulaire-put-cm/formulaire-put-cm.component';
import { FormulaireAddCmComponent } from './acceuil/admin/formulaires/cmFormulaires/formulaire-add-cm/formulaire-add-cm.component';
import { FormateurUserComponent } from './acceuil/admin/formateur-user/formateur-user.component';
import { FormulairePutFormateurComponent } from './acceuil/admin/formulaires/formateurFormulaires/formulaire-put-formateur/formulaire-put-formateur.component';
import { FormulaireAddFormateurComponent } from './acceuil/admin/formulaires/formateurFormulaires/formulaire-add-formateur/formulaire-add-formateur.component';
import { GroupeCompetenceComponent } from './acceuil/admin/groupe-competence/groupe-competence.component';
import { FormulairePutGrpCompetenceComponent } from './acceuil/admin/formulaires/grpCompetenceFormulaires/formulaire-put-grp-competence/formulaire-put-grp-competence.component';
import { FormulaireAddGrpCompetenceComponent } from './acceuil/admin/formulaires/grpCompetenceFormulaires/formulaire-add-grp-competence/formulaire-add-grp-competence.component';
import { DetailsGrpCompetenceComponent } from './acceuil/admin/groupe-competence/details-grp-competence/details-grp-competence.component';
import { DetailsCompetencesComponent } from './acceuil/admin/competences/details-competences/details-competences.component';
import { CompetencesComponent } from './acceuil/admin/competences/competences.component';
import { FormulairePutCompetenceComponent } from './acceuil/admin/formulaires/competencesFormulaires/formulaire-put-competence/formulaire-put-competence.component';
import { FormulaireAddCompetenceComponent } from './acceuil/admin/formulaires/competencesFormulaires/formulaire-add-competence/formulaire-add-competence.component';
import { ReferentielComponent } from './acceuil/admin/referentiel/referentiel.component';
import { DetailsReferentielComponent } from './acceuil/admin/referentiel/details-referentiel/details-referentiel.component';
import { FormulairePutReferentielComponent } from './acceuil/admin/formulaires/referentielFormulaires/formulaire-put-referentiel/formulaire-put-referentiel.component';
import { FormulaireAddReferentielComponent } from './acceuil/admin/formulaires/referentielFormulaires/formulaire-add-referentiel/formulaire-add-referentiel.component';
import { PlusDeDetailsRefGrpCompComponent } from './acceuil/admin/referentiel/plus-de-details-ref-grp-comp/plus-de-details-ref-grp-comp.component';
import { PromoComponent } from './acceuil/admin/promo/promo.component';
import { FormulairePutPromoComponent } from './acceuil/admin/formulaires/promoFormulaires/formulaire-put-promo/formulaire-put-promo.component';
import { FormulaireAddPromoComponent } from './acceuil/admin/formulaires/promoFormulaires/formulaire-add-promo/formulaire-add-promo.component';
import { DetailsPromoComponent } from './acceuil/admin/promo/details-promo/details-promo.component';


const routes: Routes = [
  { path: '', pathMatch: 'full', redirectTo: 'connexion'},
  { path: 'connexion', component: ConnexionComponent },
  { path: 'acceuil', component: AcceuilComponent, canActivate: [AuthGuard],
        children:[
              { path: 'liste/profils', component: ProfilComponent,
                    children:[
                      { path: ':id/details', component: DetailsProfilComponent },
                      { path: ':id/modifier', component: ProfilComponent },
                      { path: ':id/delete', component: ProfilComponent }
                    ]
              },
              { path: 'liste/admins', component: AdminUserComponent,
                    children:[
                      { path: ':id/delete', component: AdminUserComponent },
                      { path: ':id/modifier', component: FormulairePutAdminComponent }
                    ]
              },
              { path: 'ajouter/admin', component: FormulaireAddAdminComponent },

              { path: 'liste/apprenants', component: ApprenantUserComponent,
                    children:[
                      { path: ':id/delete', component: ApprenantUserComponent },
                      { path: ':id/modifier', component: FormulairePutApprenantComponent }
                    ]
              },
              { path: 'ajouter/apprenant', component: FormulaireAddApprenantComponent },

              { path: 'liste/cms', component: CmUserComponent,
                    children:[
                      { path: ':id/delete', component: CmUserComponent },
                      { path: ':id/modifier', component: FormulairePutCmComponent }
                    ]
              },
              { path: 'ajouter/cm', component: FormulaireAddCmComponent },

              { path: 'liste/formateurs', component: FormateurUserComponent,
                    children:[
                      { path: ':id/delete', component: FormateurUserComponent },
                      { path: ':id/modifier', component: FormulairePutFormateurComponent }
                    ]
              },
              { path: 'ajouter/formateur', component: FormulaireAddFormateurComponent },

              { path: 'liste/groupeCompetences', component: GroupeCompetenceComponent,
                    children:[
                      { path: ':id/details', component: DetailsGrpCompetenceComponent },
                      { path: ':id/delete', component: GroupeCompetenceComponent },
                      { path: ':id/modifier', component: FormulairePutGrpCompetenceComponent }
                    ]
              },
              { path: 'ajouter/groupeCompetence', component: FormulaireAddGrpCompetenceComponent }, 

              { path: 'liste/competences', component: CompetencesComponent,
                    children:[
                      { path: ':id/details', component: DetailsCompetencesComponent },
                      { path: ':id/delete', component: CompetencesComponent },
                      { path: ':id/modifier', component: FormulairePutCompetenceComponent }
                    ]
              },
              { path: 'ajouter/competence', component: FormulaireAddCompetenceComponent },

              { path: 'liste/referentiels', component: ReferentielComponent,
                    children:[
                      { path: ':id/details', component: DetailsReferentielComponent,
                            children:[
                              { path: ':id/competences', component: PlusDeDetailsRefGrpCompComponent }
                            ]
                      },
                      { path: ':id/modifier', component: FormulairePutReferentielComponent }
                    ]
              },
              { path: 'ajouter/referentiel', component: FormulaireAddReferentielComponent },

              { path: 'liste/promos', component: PromoComponent,
                    children:[
                      { path: ':id/details', component: DetailsPromoComponent },
                      { path: ':id/modifier', component: FormulairePutPromoComponent }
                    ]
              },
              { path: 'ajouter/promo', component: FormulaireAddPromoComponent }
        ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { relativeLinkResolution: 'legacy' })],
  exports: [RouterModule]
})
export class AppRoutingModule { }