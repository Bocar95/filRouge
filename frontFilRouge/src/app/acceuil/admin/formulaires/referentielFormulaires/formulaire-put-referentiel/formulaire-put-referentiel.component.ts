import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router, RouterStateSnapshot } from '@angular/router';
import { GroupeCompetenceService } from 'src/app/service/groupeCompetenceService/groupe-competence.service';
import { ReferentielService } from 'src/app/service/referentielService/referentiel.service';

@Component({
  selector: 'app-formulaire-put-referentiel',
  templateUrl: './formulaire-put-referentiel.component.html',
  styleUrls: ['./formulaire-put-referentiel.component.css']
})
export class FormulairePutReferentielComponent implements OnInit {

  referentiel = {};
  snapshot: RouterStateSnapshot;
  url;
  id;

  puttingReferentielForm : FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);
  presentationFormControl = new FormControl('', [Validators.required]);
  programmeFormControl = new FormControl();
  critereEvaluationFormControl = new FormControl('', [Validators.required]);
  critereAdmissionFormControl = new FormControl('', [Validators.required]);
  grpCompetenceFormControl = new FormControl();
  grpCompetenceList = [];
  value;
  
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private referentielService : ReferentielService,
    private grpCompetenceService: GroupeCompetenceService
  ) { }

  ngOnInit(): void {
    this.referentielService.getById(this.getIdOnUrl()).subscribe(
      (data : any) => {
        this.referentiel = data,
        console.log(data)
      }
    );
    this.grpCompetenceService.getGrpCompetences().subscribe(
      (res : any)=>{
        this.grpCompetenceList= res,
        console.log(res)
      });
    this.puttingReferentielForm = this.formBuilder.group({
      libelle : this.libelleFormControl,
      presentation : this.presentationFormControl,
      programme : this.programmeFormControl,
      critereEvaluation : this.critereEvaluationFormControl,
      critereAdmission : this.critereAdmissionFormControl,
      groupeCompetences : this.grpCompetenceFormControl
    });
  }

  getIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    this.id = this.url.split('/');
    return this.id[4];
  }

  reloadComponentWithAlert() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/liste/referentiels']);
    alert('Données mofifier avec success');
  }

  onClickBtnValider() {
    if(this.libelleFormControl.value==null){
      this.libelleFormControl.setValue(this.referentiel['libelle']);
    }
    if(this.presentationFormControl.value==null){
      this.presentationFormControl.setValue(this.referentiel['presentation']);
    }
    if(this.programmeFormControl.value==null){
      this.programmeFormControl.setValue(this.referentiel['programme']);
    }
    if(this.critereEvaluationFormControl.value==null){
      this.critereEvaluationFormControl.setValue(this.referentiel['critereEvaluation']);
    }
    if(this.critereAdmissionFormControl.value==null){
      this.critereAdmissionFormControl.setValue(this.referentiel['critereAdmission']);
    }
    if(this.grpCompetenceFormControl.value==null){
      this.grpCompetenceFormControl.setValue(this.referentiel['groupeCompetences']);
    }
    this.puttingReferentielForm = this.formBuilder.group({
      libelle : this.libelleFormControl,
      presentation : this.presentationFormControl,
      programme : this.programmeFormControl,
      critereEvaluation : this.critereEvaluationFormControl,
      critereAdmission : this.critereAdmissionFormControl,
      groupeCompetences : this.grpCompetenceFormControl
    });

    if(this.puttingReferentielForm.value){
      var id = this.getIdOnUrl();
      return this.referentielService.putReferentiel(id, this.puttingReferentielForm.value).subscribe(
        (res: any) => {
          console.log(res)
        }
      ), this.reloadComponentWithAlert();
    }
  }

}
