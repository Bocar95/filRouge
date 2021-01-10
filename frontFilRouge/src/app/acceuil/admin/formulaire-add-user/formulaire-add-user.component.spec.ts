import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAddUserComponent } from './formulaire-add-user.component';

describe('FormulaireAddUserComponent', () => {
  let component: FormulaireAddUserComponent;
  let fixture: ComponentFixture<FormulaireAddUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAddUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulaireAddUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
