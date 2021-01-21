import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAddGrpCompetenceComponent } from './formulaire-add-grp-competence.component';

describe('FormulaireAddGrpCompetenceComponent', () => {
  let component: FormulaireAddGrpCompetenceComponent;
  let fixture: ComponentFixture<FormulaireAddGrpCompetenceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAddGrpCompetenceComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulaireAddGrpCompetenceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
