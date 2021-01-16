import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAddCmComponent } from './formulaire-add-cm.component';

describe('FormulaireAddCmComponent', () => {
  let component: FormulaireAddCmComponent;
  let fixture: ComponentFixture<FormulaireAddCmComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAddCmComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulaireAddCmComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
