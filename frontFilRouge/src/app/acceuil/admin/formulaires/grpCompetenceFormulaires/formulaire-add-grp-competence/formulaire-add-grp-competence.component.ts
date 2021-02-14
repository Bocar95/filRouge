import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { MatTableDataSource } from '@angular/material/table';
import { Router } from '@angular/router';
import { CompetenceServiceService } from 'src/app/service/competenceService/competence-service.service';
import { GroupeCompetenceService } from 'src/app/service/groupeCompetenceService/groupe-competence.service';

@Component({
  selector: 'app-formulaire-add-grp-competence',
  templateUrl: './formulaire-add-grp-competence.component.html',
  styleUrls: ['./formulaire-add-grp-competence.component.css']
})
export class FormulaireAddGrpCompetenceComponent implements OnInit {

  addingGrpCompetence: FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);
  descriptifFormControl = new FormControl('', [Validators.required]);
  competenceFormControl = new FormControl();
  competenceLibelleFormControl = new FormControl();
  competenceDescriptifFormControl = new FormControl();
  competenceList = [];
  disabled = false;
  plus = 'pi pi-plus';
  times = 'pi pi-times';
  selectedCompetence:any;
  btnText = 'Ajouter';
  dataSource = new MatTableDataSource(this.competenceList);

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private groupeCompetenceService: GroupeCompetenceService,
    private competenceService : CompetenceServiceService
  ) { }

  ngOnInit(): void {
    this.competenceService.getCompetences().subscribe(
      (data : any)=>{
        this.competenceList = data,
        console.log(data)
      });
    this.addingGrpCompetence = this.formBuilder.group({
      libelle : this.libelleFormControl,
      descriptif : this.descriptifFormControl,
      competences : this.competenceFormControl,
      competenceLibelle : this.competenceLibelleFormControl,
      competenceDescriptif : this.competenceDescriptifFormControl
    });
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/ajouter/groupeCompetence']);
    alert("Ajouter avec success");
  }

  onClickBtnAdd() {
    console.log(this.addingGrpCompetence.value);
    if(this.addingGrpCompetence.value){
      return this.groupeCompetenceService.addGrpCompetence(this.addingGrpCompetence.value).subscribe(
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
