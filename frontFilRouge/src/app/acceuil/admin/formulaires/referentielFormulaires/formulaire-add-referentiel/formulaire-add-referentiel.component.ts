import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { GroupeCompetenceService } from 'src/app/service/groupeCompetenceService/groupe-competence.service';
import { ReferentielService } from 'src/app/service/referentielService/referentiel.service';

@Component({
  selector: 'app-formulaire-add-referentiel',
  templateUrl: './formulaire-add-referentiel.component.html',
  styleUrls: ['./formulaire-add-referentiel.component.css']
})
export class FormulaireAddReferentielComponent implements OnInit {

  addingReferentiel: FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);
  presentationFormControl = new FormControl('', [Validators.required]);
  programmeFormControl = new FormControl();
  critereEvaluationFormControl = new FormControl('', [Validators.required]);
  critereAdmissionFormControl = new FormControl('', [Validators.required]);
  grpCompetenceFormControl = new FormControl();
  grpCompetenceList = [];
  uploadedFiles: any[] = [];
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private referentielService : ReferentielService,
    private groupeCompetenceService: GroupeCompetenceService,
    private messageService : MessageService
  ) { }

  ngOnInit(): void {
    this.groupeCompetenceService.getGrpCompetences().subscribe(
      (data : any)=>{
        this.grpCompetenceList = data,
        console.log(data)
      });
    this.addingReferentiel = this.formBuilder.group({
      libelle : this.libelleFormControl,
      presentation : this.presentationFormControl,
      programme : this.programmeFormControl,
      critereEvaluation : this.critereEvaluationFormControl,
      critereAdmission : this.critereAdmissionFormControl,
      groupeCompetences : this.grpCompetenceFormControl
    });

  }

  onUpload(event) {
    for(let file of event.files) {
        this.uploadedFiles.push(file);
    }
    this.messageService.add({severity: 'info', summary: 'File Uploaded', detail: ''});
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/ajouter/referentiel']);
    alert("Ajouter avec success");
  }

  onClickBtnAdd() {
    console.log(this.addingReferentiel.value);
    if(this.addingReferentiel.value){
      return this.referentielService.addReferentiel(this.addingReferentiel.value).subscribe(
        (res: any) => {
          console.log(res)
        }
      ),this.reloadComponent();
    }
  }

}
