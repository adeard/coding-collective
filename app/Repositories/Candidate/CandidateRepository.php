<?php
namespace App\Repositories\Candidate;

use App\Models\Candidate;
use App\Models\CandidateSkills;
use App\Repositories\Candidate\CandidateInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use \Carbon\Carbon;

class CandidateRepository implements CandidateInterface{

    protected $candidate;

    public function __construct(Candidate $candidate)
	{
        $this->candidate = $candidate;
    }

    public function getAll()
    {
        return $this->candidate->with(['candidateSkills', 'appliedRoles'])->get();
    }

    public function findById($id)
    {
        return $this->candidate->with(['candidateSkills', 'appliedRoles'])->find($id);
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'education' => 'required|string',
            'birth_date' => 'required|date',
            'experience' => 'required|integer',
            'last_position' => 'required|string',
            'role_id' => 'required|integer',
            'email' => 'required|string',
            'phone' => 'required|string',
            'resume' => 'required|file|mimetypes:application/pdf',
            'skills' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors(), 422);
        }

        $candidate = new Candidate();
        $candidate->name = $request->name;
        $candidate->education = $request->education;
        $candidate->birth_date = $request->birth_date;
        $candidate->experience = $request->experience;
        $candidate->last_position = $request->last_position;
        $candidate->role_id = $request->role_id;
        $candidate->email = $request->email;
        $candidate->phone = $request->phone;
        $candidate->resume = $filename;

        if ($candidate->save()) {
            if ($request->file('resume')) {
                $this->uploadCandidateFile($candidate, $request->file('resume'));
            }

            $this->addCandidateSkills($candidate->id, $request->skills);

            return $this->findById($candidate->id);
        } else {
            return ['message' => 'Fails to save todo'];
        }
    }

    public function update($request)
    {
        $id = $request->route('id');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'education' => 'required|string',
            'birth_date' => 'required|date',
            'experience' => 'required|integer',
            'last_position' => 'required|string',
            'role_id' => 'required|integer',
            'email' => 'required|string',
            'phone' => 'required|string',
            'resume' => 'file|mimetypes:application/pdf',
            'skills' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors(), 422);
        }

        $candidate = Candidate::with('candidateSkills')->find($id);
        $candidate->name = $request->name;
        $candidate->education = $request->education;
        $candidate->birth_date = $request->birth_date;
        $candidate->experience = $request->experience;
        $candidate->last_position = $request->last_position;
        $candidate->role_id = $request->role_id;
        $candidate->email = $request->email;
        $candidate->phone = $request->phone;

        if ($candidate->save()) {
            if ($request->file('resume')) {
                $this->uploadCandidateFile($candidate, $request->file('resume'));
            }

            $this->addCandidateSkills($candidate->id, $request->skills);

            return $this->findById($candidate->id);
        } else {
            return ['message' => 'Fails to save todo'];
        }
    }

    public function updateResume($request)
    {
        $validator = Validator::make($request->all(), [
            'candidate_id' => 'required|integer',
            'resume' => 'required|file|mimetypes:application/pdf',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors(), 422);
        }

        $candidate = Candidate::find($request->candidate_id);
        if (!$candidate) {
            throw new \Exception('Candidate Not Found', 404);
        }

        $result = $this->uploadCandidateFile($candidate, $request->file('resume'));

        return $result;
    }

    public function uploadCandidateFile(Candidate $candidate, $file)
    {
        $resumeUrl = $_SERVER['DOCUMENT_ROOT'].'/coding-collective/resume/';
        $filename = $resumeUrl.time().' - '.$file->getClientOriginalName();

        if (!is_dir($resumeUrl))
            mkdir($resumeUrl, 0777, true);

        $file->move($resumeUrl, $file->getClientOriginalName());
        rename($resumeUrl.$file->getClientOriginalName(), $filename);

        $candidate->resume = $filename;
        $candidate->save();

        return $filename;
    }

    public function addCandidateSkills($candidateId, $skills)
    {
        $skills = explode(', ',$skills);

        CandidateSkills::where('candidate_id', $candidateId)->delete();

        $candidateSkills = [];
        foreach ($skills as $skill) {
            $candidateSkills[] = [
                'candidate_id' => $candidateId,
                'name' => $skill,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $result = CandidateSkills::insert($candidateSkills);

        return $result;
    }
}
