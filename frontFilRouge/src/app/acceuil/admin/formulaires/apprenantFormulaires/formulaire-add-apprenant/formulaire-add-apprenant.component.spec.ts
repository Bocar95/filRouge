import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAddApprenantComponent } from './formulaire-add-apprenant.component';

describe('FormulaireAddApprenantComponent', () => {
  let component: FormulaireAddApprenantComponent;
  let fixture: ComponentFixture<FormulaireAddApprenantComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAddApprenantComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulaireAddApprenantComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
