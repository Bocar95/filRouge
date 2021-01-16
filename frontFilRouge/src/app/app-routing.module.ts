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
        ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }