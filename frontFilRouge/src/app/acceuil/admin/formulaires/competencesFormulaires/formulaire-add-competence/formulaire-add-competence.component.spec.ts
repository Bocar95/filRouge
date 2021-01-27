import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAddCompetenceComponent } from './formulaire-add-competence.component';

describe('FormulaireAddCompetenceComponent', () => {
  let component: FormulaireAddCompetenceComponent;
  let fixture: ComponentFixture<FormulaireAddCompetenceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAddCompetenceComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulaireAddCompetenceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
