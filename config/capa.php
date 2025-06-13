<?php
return [
    'capa_form' => [
        'capa_create' => [
            'type' => [
                'corrective_action' => 'acțiuni corective',
                'corrective_action_provider' => 'acțiune corectivă - furnizor',
                'preventive_action' => 'actiune preventiva',
                'opportunity_for_improvement' => 'oportunitate de îmbunătățire / sugestie',
            ],
            'source' => [
                'other' => 'alte',
                'management_review_action_item' => 'articolul de revizuire a conducerii',
                'external_audit_finding' => 'constatarea auditului extern',
                'internal_audit_finding' => 'constatarea auditului intern',
                'employee_feedback' => 'feedback-ul angajatului',
                'customer_feedback' => 'feedback-ul clientului',
                'supplier_feedback' => 'feedback-ul furnizorilor / feedback-ul subcontractorilor',
            ],
            'process' => [
                'capa' => 'acțiunea corectivă și acțiune preventivă',
                'other' => 'alte',
                'customer_communication' => 'comunicarea cu clienții',
                'document_control' => 'controlul documentelor',
                'purchasing' => 'cumpărare',
                'manufacturing' => 'de fabricație',
                'risk_assessment' => 'evaluare a riscurilor',
                'maintenance' => 'întreținere',
                'training' => 'pregătire',
                'waste_treatment' => 'tratarea deșeurilor',
                'verification' => 'verificare',
            ],
            'priority' => [
                'high' => 'înalt',
                'medium' => 'mediu',
                'low' => 'scăzut',
                'urgent' => 'urgent'
            ],
        ],
        'capa_plan' => [
            'result' => [
                '' => '',
                'pass' => 'admis',
                'fail' => 'respins'
            ],
        ],
    ],
];
