import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { CompetenceServiceService } from 'src/app/service/competenceService/competence-service.service';
import { NiveauxService } from 'src/app/service/niveauxService/niveaux.service';

@Component({
  selector: 'app-formulaire-add-competence',
  templateUrl: './formulaire-add-competence.component.html',
  styleUrls: ['./formulaire-add-competence.component.css']
})
export class FormulaireAddCompetenceComponent implements OnInit {

  addingCompetence: FormGroup;

  //addingNiveau : FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);
  descriptifFormControl = new FormControl('', [Validators.required]);
  competenceFormControl = new FormControl();
  niveauCritereEvaluation1FormControl = new FormControl();
  niveauCritereEvaluation2FormControl = new FormControl();
  niveauCritereEvaluation3FormControl = new FormControl();
  niveauGroupeAction1FormControl = new FormControl();
  niveauGroupeAction2FormControl = new FormControl();
  niveauGroupeAction3FormControl = new FormControl();
  
  competenceList = [];
  niveauCompetencesList = [];

  showForms = false;
  btnText = 'Ajouter';
  disabled = false;
  plus = 'pi pi-plus';
  times = 'pi pi-times';
  
  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private competenceService: CompetenceServiceService,
    private niveauService: NiveauxService
  ) { }

  ngOnInit(): void {
    this.competenceService.getCompetences().subscribe(
      (data : any)=>{
        this.competenceList = data,
        console.log(data)
      });
    this.addingCompetence = this.formBuilder.group({
      libelle : this.libelleFormControl,
      descriptif : this.descriptifFormControl,
      niveauCritereEvaluation1 :this.niveauCritereEvaluation1FormControl,
      niveauCritereEvaluation2 :this.niveauCritereEvaluation2FormControl,
      niveauCritereEvaluation3 :this.niveauCritereEvaluation3FormControl,
      niveauGroupeAction1 : this.niveauGroupeAction1FormControl,
      niveauGroupeAction2 : this.niveauGroupeAction2FormControl,
      niveauGroupeAction3 : this.niveauGroupeAction3FormControl
    });
    this.niveauService.getNiveaux().subscribe(
      (niveaux : any)=>{
        this.niveauCompetencesList = niveaux,
        console.log(niveaux)
      }
    );
  }

  // niveaux() {
  //   if (this.showForms == true){
  //     return this.addingNiveau = this.formBuilder.group({
  //       libelle : this.niveauLibelleFormControl,
  //       critereEvaluation : this.niveauCritereEvaluationFormControl,
  //       groupeAction : this.niveauGroupeActionFormControl
  //     });
  //   }
  //   this.addingNiveau = this.formBuilder.group({
  //     libelle : this.niveauLibelleFormControl,
  //     critereEvaluation : this.niveauCritereEvaluationFormControl,
  //     groupeAction : this.niveauGroupeActionFormControl
  //   });
  //   return this.niveauCompetencesFormControl;
  // }

  status() {
    return this.showForms;
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/ajouter/competence']);
    alert("Ajouter avec success");
  }

  showOrHide(){
    if(this.showForms == false){
      this.showForms = true;
      return true;
    }
    this.showForms = false;
    return false;
  }

  onClickBtnAdd() {
    console.log(this.addingCompetence.value);
    if(this.addingCompetence.value){
      return this.competenceService.addCompetence(this.addingCompetence.value).subscribe(
        (res: any) => {
          console.log(res)
        }
      ),this.reloadComponent();
    }
  }

  disableState(){
    if(this.disabled == false ){
      return this.disabled = true;
    }
    return this.disabled = false;
  }

  btnState() {
    if (this.disabled == false){
      return this.plus;
    }
    return this.times;
  }

}
